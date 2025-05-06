@extends('backend.layout.master')


@section('content')
  <div id="app" class="content-header">
      <div class="container-fluid">
          <div class="row mb-2">
              <div class="col-sm-6">
                  <h1 class="m-0">teacher</h1>
              </div>
              <div class="col-sm-6">
                  <ol class="breadcrumb float-sm-right">
                      <li class="breadcrumb-item"><a href="#">Home</a></li>
                      <li class="breadcrumb-item active">Dashboard v3</li>
                  </ol>
              </div>
          </div>
          <div class="col-12">
            
          </div>
             

@endsection

@section( 'js')
    <!-- Vue Script -->

    <script>
        var app = new Vue({
            el: '#app',
            delimiters: ['[[', ']]'],
            data: {
                teacher_list: [],
                status: 'add',
                FormData: {
                    id: null,
                    teacher_code: null,
                    teacher_name: null,
                    teacher_dob: null,
                    teacher_email: '@gmail.com',
                    teacher_phone: null,
                    address: null,
                    teacher_profile: null,
                    teacher_image: null,
                    gender: '1',
                },
            },
            created() {
                this.fetchData();
            },
            methods: {
                fetchData() {
                    let vm = this;
                    $.LoadingOverlay("show");
                    axios.get('/dashboard/teacher/fetchDataRecord')
                        .then(function (response) {
                            vm.teacher_list = response.data;
                            $.LoadingOverlay("hide");
                        })
                        .catch(function (error) {
                            alert(error);
                        });
                },
                createRecord() {
                    let vm = this;
                    let input = vm.FormData;
                    axios.post('/dashboard/teacher/createTeacherRecord', input)
                        .then(function (response) {
                            Swal.fire({
                                position: "top-end",
                                icon: "success",
                                title: "Success!",
                                text: "Teacher created successfully!✅",
                                showConfirmButton: false,
                                timer: 1500,
                            }).then(() => {
                                window.location.reload();
                            });
                            vm.resetData();
                        })
                        .catch(function (error) {
                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                text: "Error creating teacher: " + error.response.data.message,
                            });
                        });
                },
                editRecord(item) {

                    this.status = 'edit'; // Set status to 'edit'
                    this.FormData.id = item.id; // Set the ID
                    this.FormData.teacher_name = item.teacher_name; // Set the course code
                    this.FormData.teacher_dob = item.teacher_dob; // Set the course name
                    this.FormData.teacher_email = item.teacher_email; // Set the course description
                    this.FormData.teacher_phone = item.teacher_phone; // Set the course fee
                    this.FormData.address = item.address; // Set the course duration
                    this.FormData.teacher_profile = item.teacher_profile; // Set the course instructor
                    this.FormData.teacher_image = item.teacher_image; // Set the course image
                    this.FormData.gender = item.gender;// Set the gender


                    this.showModal(); // Show the Modal
                },
                updateRecord() {
                    let vm = this;
                    let input = vm.FormData;
                    axios.post('/dashboard/teacher/updateTeacherRecord', input)
                        .then(function (response) {
                            if (response.data.success) {
                                Swal.fire({
                                    position: "top-end",
                                    icon: "success",
                                    title: "Success!",
                                    text: "Teacher updated successfully!✅",
                                    showConfirmButton: false,
                                    timer: 1500,
                                });
                                vm.status = 'add';
                                vm.resetData();
                                vm.fetchData();
                                vm.hideModal();
                            } else {
                                Swal.fire({
                                    icon: "error",
                                    title: "Error",
                                    text: response.data.message,
                                });
                            }
                        })
                        .catch(function (error) {
                            let errorMessage = "Error updating teacher.";
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
                deleteRecord(teacherId) {
                    Swal.fire({
                        title: "Are you sure?",
                        text: "This record will be permanently removed! ⚠️",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Yes, delete it!",
                        cancelButtonText: "Cancel",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            let vm = this;
                            axios.delete(`/dashboard/teacher/deleteTeacherRecord/${teacherId}`)
                                .then(function (response) {
                                    Swal.fire({
                                        position: "top-end",
                                        icon: "success",
                                        title: "Permanently Removed! 🛑",
                                        text: response.data.message,
                                        showConfirmButton: false,
                                        timer: 1500,
                                    });
                                    vm.fetchData();
                                })
                                .catch(function (error) {
                                    Swal.fire({
                                        position: "top-end",
                                        icon: "error",
                                        title: "Error",
                                        text: "Error deleting teacher: " + error.response.data.message,
                                    });
                                });
                        }
                    });
                },
                resetData() {
                    this.FormData = {
                        id: null,
                        teacher_code: null,
                        teacher_name: null,
                        teacher_dob: null,
                        teacher_email: null,
                        teacher_phone: null,
                        address: null,
                        teacher_profile: null,
                        teacher_image: null,
                        gender: '1',
                        
                    };
                    this.status = 'add';
                    this.hideModal();
                },
                showModal() {
                    this.FormData.teacher_code = this.generateCode();
                    $('#staticBackdrop').modal('show');
                },
                hideModal() {
                    $('#staticBackdrop').modal('hide');
                },
                generateCode() {
                    let now = new Date();
                    let year = now.getFullYear().toString().slice(-2);
                    let month = String(now.getMonth() + 1).padStart(2, "0");
                    let day = String(now.getDate()).padStart(2, "0");
                    let hour = String(now.getHours()).padStart(2, "0");
                    let minute = String(now.getMinutes()).padStart(2, "0");
                    let second = String(now.getSeconds()).padStart(2, "0");
                    return `T-${year}${month}${day}${hour}${minute}${second}`;
                },
                previewImage(event) {
                    let file = event.target.files[0];
                    if (file) {
                        let reader = new FileReader();
                        reader.onload = (e) => {
                            this.FormData.teacher_image = e.target.result;
                            
                        };
                        reader.readAsDataURL(file);
                        
                    }
                },
                clearData(){
                    
                    this.FormData.teacher_name = null;
                    this.FormData.teacher_dob = null;
                    this.FormData.teacher_email = null;
                    this.FormData.teacher_phone = null;
                    this.FormData.teacher_address = null;
                    this.FormData.teacher_profile = null;
                    this.FormData.teacher_image = null;
                    this.FormData.gender = '1';
                }
            }
        });
    </script>









@endsection

@section('datatable')

  <script>
      $(function () {
        $("#example1").DataTable({
          "responsive": true, "lengthChange": false, "autoWidth": false,
          "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $('#example2').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": false,
          "responsive": true,
        });
      });
  </script>


@endsection
