@extends('backend.layout.master')

@section('content')
<div id="app" class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Teacher</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard v3</li>
                </ol>
            </div>
        </div>

        <!-- Teacher Table -->
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Teacher Table</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm">
                            <div class="input-group-append">
                                <!-- Button trigger modal -->
                                <a class="btn btn-outline-primary" @click="showModal()" v-if="status == 'add'">
                                    <i class="fas fa-plus"></i> Create Teacher
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Table Body -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Photo</th>
                                <th>Teacher Code</th>
                                <th>Teacher Name</th>
                                <th>Date of Birth</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Gender</th>
                                <th>Address</th>
                                <th>Profile</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in teacher_list" :key="index">
                                <td>[[ index + 1 ]]</td>
                                <td>
                                    <img
                                        :src="'/storage/' + item.teacher_image"
                                        alt="teacher_photo"
                                        :width="100"
                                        :height="100"
                                        class="img-size-50 mr-3 img-circle"
                                    />
                                </td>
                                <td>[[ item.teacher_code ]]</td>
                                <td>[[ item.teacher_name ]]</td>
                                <td>[[ item.teacher_dob ]]</td>
                                <td>[[ item.teacher_email ]]</td>
                                <td>[[ item.teacher_phone ]]</td>
                                <td>[[ item.gender === 'Male' ? 'Male👨' : item.gender === 'Female' ? 'Female👩' : 'Other⚧️' ]]</td>
                                <td>[[ item.address ]]</td>
                                <td>[[ item.teacher_profile ]]</td>
                                <td>
                                    <a class="btn btn-outline-warning" @click="editRecord(item)">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <button type="button" class="btn btn-outline-danger" @click="deleteRecord(item.id)">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal for Adding/Editing Teacher -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">[[status == 'add' ? 'Add Teacher' : 'Edit Teacher']]</h5>
                        <button type="button" class="btn-close" @click="resetData()" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container mt-5">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <!-- Teacher Form -->
                                            <div class="form-row">
                                                <div v-if="status == 'add'" class="form-group col-md-6">
                                                    <label class="form-label">Teacher Code</label>
                                                    <input class="form-control" v-model="FormData.teacher_code" required disabled>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="form-label">Teacher Name</label>
                                                    <input type="text" class="form-control" v-model="FormData.teacher_name" placeholder="Teacher name" required>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label class="form-label">Date of Birth</label>
                                                    <input type="date" class="form-control" v-model="FormData.teacher_dob" required>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="form-label">Email</label>
                                                    <input type="email" class="form-control" v-model="FormData.teacher_email" placeholder="Teacher email" required>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label class="form-label">Phone</label>
                                                    <input type="tel" class="form-control" v-model="FormData.teacher_phone" placeholder="Teacher phone" required>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="form-label">Gender</label>
                                                    <select class="form-select" v-model="FormData.gender">
                                                        <option value="1">Male</option>
                                                        <option value="2">Female</option>
                                                        <option value="3">Other</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Address</label>
                                                <textarea class="form-control" v-model="FormData.address" rows="3" placeholder="Enter teacher address"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Profile</label>
                                                <textarea class="form-control" v-model="FormData.teacher_profile" rows="3" placeholder="Enter teacher profile"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Upload Profile Picture (PNG, JPG)</label>
                                                <input type="file" class="form-control" accept="image/*" @change="previewImage">
                                            </div>
                                            <div v-if="FormData.teacher_image" class="mb-3">
                                                <label class="form-label">Image Preview</label>
                                                <img :src="FormData.teacher_image" alt="Profile Picture" class="img-thumbnail" style="max-width: 200px;">
                                            </div>
                                            <div class="mb-3">
                                                <button @click="createRecord()" v-if="status == 'add'" type="submit" class="btn btn-primary">Save</button>
                                                <button @click="updateRecord()" v-if="status == 'edit'" type="submit" class="btn btn-warning">Update</button>
                                                <button type="button" class="btn btn-secondary ms-2" @click="clearData()">Clear</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="resetData()">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- - Modal for Adding/Editing Teacher End -->
    </div>
</div>
@endsection

@section('js')
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
                this.status = 'edit';
                this.FormData.id = item.id;
                this.FormData.teacher_name = item.teacher_name;
                this.FormData.teacher_dob = item.teacher_dob;
                this.FormData.teacher_email = item.teacher_email;
                this.FormData.teacher_phone = item.teacher_phone;
                this.FormData.address = item.address;
                this.FormData.teacher_profile = item.teacher_profile;
                this.FormData.teacher_image = item.teacher_image;
                this.FormData.gender = item.gender;
                this.showModal();
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
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: error.response.data.message || "Error updating teacher.",
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
            clearData() {
                this.FormData.teacher_name = null;
                this.FormData.teacher_dob = null;
                this.FormData.teacher_email = null;
                this.FormData.teacher_phone = null;
                this.FormData.teacher_profile = null;
                this.FormData.teacher_image = null;
                this.FormData.gender = '1';
            }
        }
    });
</script>
@endsection
