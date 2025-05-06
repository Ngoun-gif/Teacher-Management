@extends('backend.layout.master')


@section('content')
    <div id="app" class="content-header">

        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Course</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard v3</li>
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
                                        @click="clearData()"
                                        v-if="status =='add'">
                                        <i class="fas fa-plus"></i>

                                        Create Course
                                    </a>

                                    <!-- Modal -->
                                    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <h5 class="modal-title" id="staticBackdropLabel">>[[status == 'add' ? 'Add Course' : 'Edit Course']]</h5>
                                            <button type="button" class="btn-close" @click="clearData()"  aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div  class="container mt-5">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="card">
                                                                <div class="card-body">

                                                                            <div v-if="status =='add'" class="mb-3">
                                                                                <label class="form-label">Course Code</label>
                                                                                <input
                                                                                    class="form-control"
                                                                                    placeholder="Enter course code"
                                                                                    v-model="FormData.course_code"
                                                                                    required
                                                                                    disabled
                                                                                >
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label class="form-label">Course Name</label>
                                                                                <input
                                                                                type="text" class="form-control"
                                                                                placeholder="Enter course name"
                                                                                v-model="FormData.course_name"required>
                                                                            </div>

                                                                            <div class="mb-3">
                                                                                <label class="form-label">Duration (weeks)</label>
                                                                                <input type="number" class="form-control"  placeholder="Enter duration in weeks" v-model="FormData.duration" required>
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label class="form-label">Price ($)</label>
                                                                                <input type="number" class="form-control"  placeholder="Enter price" step="0.01" v-model="FormData.price" required>
                                                                            </div>

                                                                            <div class="mb-3">
                                                                                <button
                                                                                    @click="createCourseRecord()"
                                                                                    v-if="status =='add'"
                                                                                    type="submit"
                                                                                    class="btn btn-primary"
                                                                                    >Save</button>
                                                                                <button
                                                                                    @click="updateCourseRecord()"
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

                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button
                                                    @click="resetData()"
                                                    type="button"
                                                    class="btn btn-secondary">
                                                    Close
                                                </button>

                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                    <!-- Modal End -->
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
                                <th>Course Code</th>
                                <th>Course name</th>

                                <th>Duration</th>
                                <th>Price</th>
                                <th>
                                    Action
                                </th>
                            </tr>
                            </thead>
                            <tbody>

                                <tr v-for="(item, index) in courses_list" :key="index">
                                    <td>[[index + 1]] </td>
                                    <td>[[item.course_code]]</td>
                                    <td>[[item.course_name]]</td>

                                    <td>[[item.duration]] Weeks</td>
                                    <td>$[[item.course_price]]</td>
                                    <td>

                                        <a
                                            class="btn btn-outline-warning"
                                            @click="editCourseRecord(item)"

                                            >
                                            <i class ="fas fa-edit"></i>
                                            Edit
                                        </a>


                                    <button type="button"
                                            class="btn btn-outline-danger"
                                            @click="deleteCourseRecord(item.id)">
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
                course_code: null, // Stores the course code
                course_name: null, // Stores the course name
                duration: null, // Stores the duration of the course
                price: null, // Stores the price of the course
                courses_list: [], // List of courses fetched from the server
                status: 'add', // Tracks whether the form is in 'add' or 'edit' mode
                FormData: { // Object to store form data
                    id: null,
                    course_code: null,
                    course_name: null,
                    duration: null,
                    price: null,
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
                    axios.get('/dashboard/course/fetechDataRecord')
                        .then(function (response) {
                            // On success, update the courses_list with the fetched data
                            vm.courses_list = response.data;
                            $.LoadingOverlay("hide");
                        })
                        .catch(function (error) {
                            // On error, show an alert with the error message
                            alert(error);
                        });
                },

                // Creates a new course record
                createCourseRecord() {
                    let vm = this; // Reference to the Vue instance
                    let input = vm.FormData; // Form data to be sent to the server

                    axios.post('/dashboard/course/createCourseRecord', input)
                        .then(function (response) {
                            // On success, show a success message
                            Swal.fire({
                                position: "top-end",
                                icon: "success",
                                title: "Success!",
                                text: "Course created successfully!✅",
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
                                text: "Error creating course: " + error.response.data.message,
                            });
                        });
                },

                // Prepares the form for editing
                editCourseRecord(item) {
                    this.status = 'edit'; // Set status to 'edit'
                    this.FormData.id = item.id; // Set the ID
                    this.FormData.course_code = item.course_code; // Set the course code
                    this.FormData.course_name = item.course_name; // Set the course name
                    this.FormData.duration = item.duration; // Set the duration
                    this.FormData.price = item.course_price; // Set the price
                    this.showModal(); // Show the modal
                },

                // Saves the edited course record
                updateCourseRecord() {
                    let vm = this; // Reference to the Vue instance
                    let input = vm.FormData; // Form data to be sent to the server

                    // Use PUT or PATCH for updates
                    axios.post('/dashboard/course/updateCourseRecord', input)
                        .then(function (response) {
                            if (response.data.success) {
                                // On success, show a success message
                                Swal.fire({
                                    position: "top-end",
                                    icon: "success",
                                    title: "Success!",
                                    text: "Course updated successfully!✅",
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
                            let errorMessage = "Error updating course.";

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

                // Deletes a course record
                deleteCourseRecord(courseId) {
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
                            axios.delete(`/dashboard/course/deleteCourseRecord/${courseId}`)
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

                                    // Refresh the course list
                                    vm.fetchData();
                                })
                                .catch(function (error) {
                                    // On error, show an error message
                                    Swal.fire({
                                        position: "top-end",
                                        icon: "error",
                                        title: "Error",
                                        text: "Error deleting course: " + error.response.data.message,
                                    });
                                });
                        }
                    });
                },

                // Resets form data and hides the modal
                resetData() {
                    this.FormData = {
                        course_code: null,
                        course_name: null,
                        duration: null,
                        price: null,
                    };
                    this.status = 'add'; // Set status back to 'add'
                    this.hideModal(); // Hide the modal
                },

                // Clears all form fields
                clearData() {
                    this.course_code = null;
                    this.course_name = null;
                    this.duration = null;
                    this.price = null;
                    this.hideModal();
                },

                // Shows the modal
                showModal() {
                    this.FormData.course_code = this.generateCourseCode(); // Generate a new course code
                    $('#staticBackdrop').modal('show'); // Show the modal using jQuery
                },

                // Hides the modal
                hideModal() {
                    $('#staticBackdrop').modal('hide'); // Hide the modal using jQuery
                },

                // Generates a unique course code based on the current date and time
                generateCourseCode() {
                    let now = new Date();
                    let year = now.getFullYear().toString().slice(-2); // Last 2 digits of the year
                    let month = String(now.getMonth() + 1).padStart(2, "0"); // Ensure 2 digits (01-12)
                    let day = String(now.getDate()).padStart(2, "0"); // Ensure 2 digits (01-31)
                    let hour = String(now.getHours()).padStart(2, "0"); // Ensure 2 digits (00-23)
                    let minute = String(now.getMinutes()).padStart(2, "0"); // Ensure 2 digits (00-59)
                    let second = String(now.getSeconds()).padStart(2, "0"); // Ensure 2 digits (00-59)
                    return `C-${year}${month}${day}${hour}${minute}${second}`;
                },
            },

            // Lifecycle hook: Called when the Vue instance is mounted to the DOM
            mounted() {
                this.generateCourseCode(); // Generate a course code when the component is mounted
            }
        });
    </script>






    {{-- <script>
        var app = new Vue({
            el: '#app', // Vue instance will control the element with id 'app'
            delimiters: ['[[', ']]'], // Custom delimiters for Vue template syntax

            // Data properties
            data: {
                id: null, // Stores the id of the course to be edited or deleted
                course_code: null, // Stores the course code
                course_name: null, // Stores the course name

                duration: null, // Stores the duration of the course
                price: null, // Stores the price of the course
                courses_list: [], // List of courses fetched from the server
                status: 'add', // Tracks whether the form is in 'add' or 'edit' mode
                FormData: { // Object to store form data
                    id: null,
                    course_code: null,
                    course_name: null,

                    duration: null,
                    price: null,
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
                    axios.get('/dashboard/course/fetechDataRecord')
                        .then(function (response) {
                            // On success, update the courses_list with the fetched data
                            vm.courses_list = response.data;
                            $.LoadingOverlay("hide");
                        })
                        .catch(function (error) {
                            // On error, show an alert with the error message
                            alert(error);
                        });
                },

                // Creates a new course record
                createCourseRecord() {
                    let vm = this; // Reference to the Vue instance

                    let input = vm.FormData; // Form data to be sent to the server
                    axios.post('/dashboard/course/createCourseRecord', input)
                        .then(function (response) {
                            // On success, show a success message
                            Swal.fire({
                                position: "top-end",
                                icon: "success",
                                title: "Success!",
                                text: "Course created successfully!",
                                showConfirmButton: false,
                                timer: 1500, // Auto-close after 1.5 seconds
                            });
                            // Update the courses_list with the new data
                            vm.courses_list = fetchData;
                            vm.resetData(); // Reset form data
                            this.hideModal();
                            vm.fetchData();

                        })
                        .catch(function (error) {
                            // On error, show an error message
                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                text: "Error creating course: " + error.response.data.message,
                            });
                        });
                    // Reset form data and hide the modal

                    this.hideModal();
                    vm.fetchData();
                     // Clear
                },

                // Prepares the form for editing
                editCourseRecord(item) {

                    this.status = 'edit'; // Set status to 'edit'

                    this.FormData.id = item.id; // Set the ID
                    this.FormData.course_code = item.course_code; // Set the course code
                    this.FormData.course_name = item.course_name; // Set the course name

                    this.FormData.duration = item.duration; // Set the duration
                    this.FormData.price = item.course_price; // Set the price

                    this.showModal(); // Show the modal
                },
                // Saves the edited course record

                updateCourseRecord() {
                    let vm = this; // Reference to the Vue instance
                    let input = vm.FormData; // Form data to be sent to the server

                    // Use PUT or PATCH for updates
                    axios.post('/dashboard/course/updateCourseRecord', input)
                        .then(function (response) {
                            if (response.data.success) {
                                // On success, show a success message
                                Swal.fire({
                                    position: "top-end",
                                    icon: "success",
                                    title: "Success!",
                                    text: "Course updated successfully!",
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
                            let errorMessage = "Error updating course.";

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

                // Deletes a course record
                deleteCourseRecord(courseId) {
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
                            axios.delete(`/dashboard/course/deleteCourseRecord/${courseId}`)
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

                                    // Refresh the course list
                                    vm.fetchData();
                                })
                                .catch(function (error) {
                                    // On error, show an error message
                                    Swal.fire({
                                        position: "top-end",
                                        icon: "error",
                                        title: "Error",
                                        text: "Error deleting course: " + error.response.data.message,
                                    });
                                });
                        }
                    });
                },

                // Resets form data and hides the modal
                resetData() {
                    this.FormData = {
                        course_code: null,
                        course_name: null,
                        duration: null,
                        price: null,
                    };
                    this.status = 'add'; // Set status back to 'add'
                    this.hideModal(); // Hide the modal
                },

                // Clears all form fields
                clearData() {
                    this.course_code = null;
                    this.course_name = null;
                    this.duration = null;
                    this.price = null;
                    this.hideModal();
                },

                // Shows the modal
                showModal() {
                    this.FormData.course_code = this.generateCourseCode(); // Generate a new course code
                    $('#staticBackdrop').modal('show'); // Show the modal using jQuery
                     // Clear all form fieldss
                },

                // Hides the modal
                hideModal() {
                    $('#staticBackdrop').modal('hide'); // Hide the modal using jQuery
                },

                // Generates a unique course code based on the current date and time
                generateCourseCode() {
                    let now = new Date();
                    let year = now.getFullYear().toString().slice(-2); // Last 2 digits of the year
                    let month = String(now.getMonth() + 1).padStart(2, "0"); // Ensure 2 digits (01-12)
                    let day = String(now.getDate()).padStart(2, "0"); // Ensure 2 digits (01-31)
                    let hour = String(now.getHours()).padStart(2, "0"); // Ensure 2 digits (00-23)
                    let minute = String(now.getMinutes()).padStart(2, "0"); // Ensure 2 digits (00-59)
                    let second = String(now.getSeconds()).padStart(2, "0"); // Ensure 2 digits (00-59)
                    return `C-${year}${month}${day}${hour}${minute}${second}`;
                },
            },

            // Lifecycle hook: Called when the Vue instance is mounted to the DOM
            mounted() {
                this.generateCourseCode(); // Generate a course code when the component is mounted
            }
        });
    </script> --}}



@endsection
