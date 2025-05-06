@extends('backend.layout.master')


@section('content')
    <div id="app" class="content-header">
        
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Subject</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div><!-- /.col -->
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Table</h3>
                        <div class="card-tools">
                            <div class="input-group input-group-sm">
                                <div class = "input-group-append">

                                    <!-- Button trigger modal -->
                                    <a
                                        class="btn btn-outline-primary"

                                        @click="showModal()"
                                        v-if="status =='add'">
                                        <i class="fas fa-plus"></i>
                                        
                                        Create Subject
                                    </a>

                                    <!-- Modal -->
                                    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <h5 class="modal-title" id="staticBackdropLabel">[[status == 'add' ? 'Add Subject' : 'Edit Subject']]</h5>
                                            <button type="button" class="btn-close" @click="resetData()" @ aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div  class="container mt-5">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                       
                                                                            <div class="mb-3">
                                                                                <label class="form-label">Subject Name</label>
                                                                                <input 
                                                                                    class="form-control" 
                                                                                    placeholder="Enter Subject Name" 
                                                                                    v-model="FormData.subject_name" 
                                                                                    required 
                                                                                    
                                                                                >
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label class="form-label">description</label>
                                                                                <input  
                                                                                type="text" class="form-control"  
                                                                                placeholder="Enter description"  
                                                                                v-model="FormData.description"required>
                                                                            </div>                                                            
    
                                                                            <div class="mb-3">
                                                                                <button
                                                                                    @click="createSubjectRecord()"  
                                                                                    v-if="status =='add'"
                                                                                    type="submit" 
                                                                                    class="btn btn-primary"
                                                                                    >Save</button>
                                                                                <button 
                                                                                    @click="updateSubjectRecord()"
                                                                                    v-if="status =='edit' " 
                                                                                    type="submit" class="btn btn-warning"
                                                                                    >Update</button>
                                                                                <button 
                                                                                    type="button" 
                                                                                    class="btn btn-secondary ms-2" 
                                                                                    @click="clearData()"
                                                                                    >Clear</button>
                                                                            </div>
                                                                            
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <br>

                                                    <!-- User Table -->
                                                [[FormData]]
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                            <button 
                                                @click="resetData()"
                                                type="button" 
                                                class="btn btn-secondary">
                                                Close</button>

                                            </div>
                                        </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0" style="height: 300px;">
                        <table class="table table-head-fixed text-nowrap">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Subject</th>
                                <th>description</th>
                               
                                
                                <th>
                                    Action
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            
                                <tr v-for="(item, index) in subject_list" :key="index">
                                    <td>[[index + 1]] </td>
                                    <td>[[item.subject_name]]</td>
                                    <td>[[item.description]]</td>
                                    
                            
                                    <td>
                                    
                                        <a
                                            class="btn btn-outline-warning"
                                            @click="editSubjectRecord(item)"
                                            
                                            >
                                            <i class ="fas fa-edit"></i>
                                            Edit
                                        </a>
                                        

                                    <button type="button" 
                                            class="btn btn-outline-danger"
                                            @click="deleteSubjectRecord(item.id)">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                        
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>

    </div>

    @endsection

@section( 'js')
    <!-- Vue Script -->

    <script>
        var app = new Vue({
            el: '#app', // Vue instance will control the element with id 'app'
            delimiters: ['[[', ']]'], // Custom delimiters for Vue template syntax
    
            // Data properties
            data: {
                id: null, // Stores the id of the course to be edited or deleted
                subject_name: null, // Stores the course code
                description: null, // Stores the course name             
               
                 // Stores the price of the course
                subject_list: [], // List of courses fetched from the server
                status: 'add', // Tracks whether the form is in 'add' or 'edit' mode
                FormData: { // Object to store form data
                    id: null,
                    subject_name: null,
                    description: null,
                    
                },
            },
    
            // Lifecycle hook: Called when the Vue instance is created
            created() {
                this.fetchData(); // Fetch initial data when the component is created
                
            },
    
            // Methods
            methods: {
    
                // Fetches course data from the server
                fetchData() {
                    
                    let vm = this; // Reference to the Vue instance
                    $.LoadingOverlay("show");
                    axios.get('/dashboard/subject/fetechDataRecord')
                        .then(function (response) {
                            // On success, update the courses_list with the fetched data
                            vm.subject_list = response.data;
                            $.LoadingOverlay("hide");
                        })
                        .catch(function (error) {
                            // On error, show an alert with the error message
                            alert(error);
                        });
                },
    
                // Creates a new course record
                createSubjectRecord() {
                    let vm = this; // Reference to the Vue instance
                    let input = vm.FormData; // Form data to be sent to the server
    
                    axios.post('/dashboard/subject/createSubjectRecord', input)
                        .then(function (response) {
                            // On success, show a success message
                            Swal.fire({
                                position: "top-end",
                                icon: "success",
                                title: "Success!",
                                text: "Major created successfully!✅",
                                showConfirmButton: false,
                                timer: 1500, // Auto-close after 1.5 seconds
                            }).then(() => {
                                // Refresh the page after the Swal alert is closed
                                window.location.reload();
                            });
    
                            // Reset form data
                            vm.resetData();
                        })
                        .catch(function (error) {
                            // On error, show an error message
                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                text: "Error creating Major: " + error.response.data.message,
                            });
                        });
                },
    
                // Prepares the form for editing
                editSubjectRecord(item) {
                    
                    this.status = 'edit'; // Set status to 'edit'

                    this.FormData.id = item.id; // Set the ID
                    this.FormData.subject_name = item.subject_name; // Set the course code
                    this.FormData.description = item.description; // Set the course name
                   
                    this.showModal(); // Show the modal
                },
                // Saves the edited course record

                updateSubjectRecord() {
                    let vm = this; // Reference to the Vue instance
                    let input = vm.FormData; // Form data to be sent to the server

                    // Use PUT or PATCH for updates
                    axios.post('/dashboard/subject/updateSubjectRecord', input)
                        .then(function (response) {
                            if (response.data.success) {
                                // On success, show a success message
                                Swal.fire({
                                    position: "top-end",
                                    icon: "success",
                                    title: "Success!",
                                    text: "Subject updated successfully!✅",
                                    showConfirmButton: false,
                                    timer: 1500, // Auto-close after 1.5 seconds
                                });

                                // Reset the status to 'add'
                                vm.status = 'add';

                                // Reset form data
                                vm.resetData();

                                // Refresh the course list
                                vm.fetchData();

                                // Hide the modal
                                vm.hideModal();
                            } else {
                                // Handle case where no course was found
                                Swal.fire({
                                    icon: "error",
                                    title: "Error",
                                    text: response.data.message,
                                });
                            }
                        })
                        .catch(function (error) {
                            // On error, show an error message
                            let errorMessage = "Error updating Subject.";

                            if (error.response && error.response.data && error.response.data.message) {
                                errorMessage = error.response.data.message;
                            }

                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                text: errorMessage,
                            });
                        });
                },
    
                // Deletes a Major record
                deleteSubjectRecord(subjectId) {
                    Swal.fire({
                        title: "Are you sure?",
                        text: "This record will be permanently removed! ⚠️",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Yes, delete it!",
                        cancelButtonText: "Cancel",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            let vm = this; // Reference to the Vue instance
                            axios.delete(`/dashboard/subject/deletSubjectRecord/${subjectId}`)
                                .then(function (response) {
                                    // On success, show a success message
                                    Swal.fire({
                                        position: "top-end",
                                        icon: "success",
                                        title: "Permanently Remove! 🛑",
                                        text: response.data.message,
                                        showConfirmButton: false,
                                        timer: 1500, // Auto-close after 1.5 seconds
                                    });
    
                                    // Refresh the Major list
                                    vm.fetchData();
                                })
                                .catch(function (error) {
                                    // On error, show an error message
                                    Swal.fire({
                                        position: "top-end",
                                        icon: "error",
                                        title: "Error",
                                        text: "Error deleting Subject: " + error.response.data.message,
                                    });
                                });
                        }
                    });
                },
    
                // Resets form data and hides the modal
                resetData() {
                    this.FormData = {
                        subject_name: null,
                        description: null,
                        state:'1',
                    };
                    this.status = 'add'; // Set status back to 'add'
                    this.hideModal(); // Hide the modal
                },
    
                // Clears all form fields
                clearData() {
                    this.subject_name = null;
                    this.description = null;
                    
                },
    
                // Shows the modal
                showModal() {
                    
                    $('#staticBackdrop').modal('show'); // Show the modal using jQuery
                },
    
                // Hides the modal
                hideModal() {
                    $('#staticBackdrop').modal('hide'); // Hide the modal using jQuery
                }
    
                // Generates a unique course code based on the current date and time
                
            },
    
            // Lifecycle hook: Called when the Vue instance is mounted to the DOM
            // mounted() {
            //     this.generateCourseCode(); // Generate a course code when the component is mounted
            // }
        });
    </script>

    {{-- <script>
         
        var app = new Vue({
    //         el: '#app',
    //         delimiters: ['[[' , ']]'],	
           
    //         data: {
    //             course_code: null,
    //             course_name: null,
    //             syllabus: null,
    //             duration: null,
    //             price: null,
    //             courses_list: [],
    //             status:'add',
    //             FormData:{
    //                 course_code: null,
    //                 course_name: null,
    //                 syllabus: null,
    //                 duration: null,
    //                 price: null,
    //             },                                   
    //         },
    //         created() {
    //             this.fetchData();
    //         },
    //         methods: {

    //             fetchData() { 
    //                 let vm = this;                    
    //                 axios.get('/dashboard/course/fetechDataRecord')
    //                 .then(function (response) {
    //                     // handle success
    //                     vm.courses_list = response.data;
    //                 })
    //                 .catch(function (error) {
    //                     // handle error
    //                     alert(error);
    //                 });
    //             },
               
              
    //             createRecord() {
    //                 let vm = this;  
    //                 let input = vm.FormData;  
    //                 axios.post('/dashboard/course/createCourseRecord', input)
    //                 .then(function (response) {
    //                     Swal.fire({
    //                         position:"top-end",
    //                         icon: "success",
    //                         title: "Success!",
    //                         text: "Course created successfully!",
    //                         showConfirmButton: false,
    //                         timer: 1500, // Auto-close after 1.5 seconds
    //                     });
    //                     // handle success
    //                     vm.courses_list = response.data;
    //                 })
    //                 .catch(function (error) {
    //                     // handle error
    //                     Swal.fire({
    //                         icon: "error",
    //                         title: "Error",
    //                         text: "Error creating course: " + error.response.data.message,
    //                     });
    //                 });
    //                 this.resetData();
    //                 this.hideModal();
    //             },
    //             getEdit(){
    //                 this.status='edit';
    //                 this.showModal();
    //             deleteCourseRecord(courseId) {
    //                 Swal.fire({
    //                     title: "Are you sure?",
    //                     text: "This record will be permanently removed! ⚠️",
    //                     icon: "warning",
    //                     showCancelButton: true,
    //                     confirmButtonText: "Yes, delete it!",
    //                     cancelButtonText: "Cancel",
    //                 }).then((result) => {
    //                 if (result.isConfirmed) {
    //                     let vm = this;
    //                     axios.delete(`/dashboard/course/deleteCourseRecord/${courseId}`)
    //                         .then(function (response) {
    //                             // Show success message
    //                             Swal.fire({
    //                                 position:"top-end",
    //                                 icon: "success",
    //                                 title: "Permanently Remove! 🛑",
    //                                 text: response.data.message,
    //                                 showConfirmButton: false,
    //                                 timer: 1500, // Auto-close after 1.5 seconds
    //                             });

    //                             // Refresh the course list
    //                             vm.fetchData();
    //                         })
    //                         .catch(function (error) {
    //                             Swal.fire({
    //                                 position:"top-end",
    //                                 icon: "error",
    //                                 title: "Error",
    //                                 text: "Error deleting course: " + error.response.data.message,
    //                             });
    //                         });
    //                 }
    //                 });
    //             },
    //             resetData() {
    //                 this.FormData={
    //                     course_code: null,
    //                     course_name: null,
    //                     syllabus: null,
    //                     duration: null,
    //                     price: null,
    //                 }
    //                 this.status='add';
    //                 this.hideModal();
    //             },
    //             clearData() {
    //                 this.course_code = null;
    //                 this.course_name = null;
    //                 this.syllabus = null;
    //                 this.duration = null;
    //                 this.price = null;                        
    //             },
    //             showModal() {
    //                 this.FormData.course_code = this.generateCourseCode();
    //                 $('#staticBackdrop').modal('show');
    //             },

    //             hideModal() {
    //                 $('#staticBackdrop').modal('hide');
    //             },

    //             },
    //             generateCourseCode() {
    //                 let now = new Date();
    //                 let year = now.getFullYear().toString().slice(-2); // Last 2 digits of the year
    //                 let month = String(now.getMonth() + 1).padStart(2, "0"); // Ensure 2 digits (01-12)
    //                 let day = String(now.getDate()).padStart(2, "0"); // Ensure 2 digits (01-31)
    //                 let hour = String(now.getHours()).padStart(2, "0"); // Ensure 2 digits (00-23)
    //                 let minute = String(now.getMinutes()).padStart(2, "0"); // Ensure 2 digits (00-59)
    //                 let second = String(now.getSeconds()).padStart(2, "0"); // Ensure 2 digits (00-59)
    //                 return `C-${year}${month}${day}${hour}${minute}${second}`;
    //             },                  
    //         },

    //         mounted() {
    //             this.generateCourseCode();
    //         }
    //     });
     </script> --}}

@endsection
