@extends('layouts.app')
@section('content')
    <div class="container" dir="rtl" style="text-align: right">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
        @endif
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">التعديل على النموذج</div>

                    <div class="card-body">
                        <form method="POST" action="/form/{{$form->id}}">
                            @csrf
                            @method('PATCH')
                            <input hidden name="id" value="{{$form->id}}">
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">العنوان</label>

                                <div class="col-md-6">
                                    <input id="name" type="text"
                                           class="form-control @error('name') is-invalid @enderror" name="name"
                                           value="{{$form->name}}" required autocomplete="name" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>العنوان يجب ان يكون نصا</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-md-4 col-form-label text-md-right">الوصف</label>

                                <div class="col-md-6">
                                    <input id="description" type="text"
                                           class="form-control @error('description') is-invalid @enderror"
                                           name="description" value="{{$form->description}}" required
                                           autocomplete="description">

                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>الوصف يجب ان يكو نصا</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        تحديث
                                    </button>
                                    <a href="/form">
                                        <button type="button" class="btn btn-primary">
                                            الرجوع
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mt-4">
            <div class="col-md-4">
                <div class="card p-4">
                    <p>اضافة اسالة لهذا النموذج</p>
                    <button class="btn btn-primary" data-toggle="modal" data-target="#questionFormModal">اضافة</button>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-4">
                    <p class="">عرض هذا النموذج ك مسابقة</p>
                    <a href="/new_session/{{$form->id}}" class="d-block" target="_blank">
                        <button class="btn btn-primary w-100">عرض</button>
                    </a>
                </div>
            </div>
            <div class="col-md-12 mt-4">
                <table class="table">
                    <thead class="thead-light">
                    <tr>
                        <th scope="col">الترتيب</th>
                        <th scope="col">عنوان السؤال</th>
                        <th scope="col">مضمون السؤال</th>
                        <th scope="col">المدة</th>
                        <th scope="col">تاريخ اضافة السؤال</th>
                        <th scope="col">تعديل/حذف</th>
                    </tr>
                    </thead>
                    <tbody>
                    <span hidden>{{ $i=1 }}</span>
                    @foreach($questions as $question)
                        <tr>
                            <th scope="row">{{$i++}}</th>
                            <td>{{$question->title}}</td>
                            <td>{{$question->content}}</td>
                            <td>{{$question->duration}}</td>
                            <td>{{$question->created_at}}</td>
                            <td>
                                <button class="btn btn-outline-secondary" data-toggle="modal"
                                        data-target="#editFormModel{{$question->id}}">
                                    تعديل
                                </button>
                                |
                                <form method="post" action="/question/destroy" class="d-inline">
                                    @csrf
                                    @method("DELETE")
                                    <input name="id" hidden value="{{$question->id}}">
                                    <button class="btn btn-outline-secondary">
                                        حذف
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
        <!--insert model-->
        <div class="modal fade" id="questionFormModal" tabindex="-1" aria-labelledby="questionFormModal"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="/question" method="post">
                        @csrf
                        <div class="modal-body">
                            <input hidden name="form_id" value="{{$form->id}}">
                            <div class="form-group">
                                <label for="title" class="col-form-label">عنوان السؤال:</label>
                                <input type="text" placeholder="نص" class="form-control" id="title" name="title">
                            </div>
                            <div class="form-group">
                                <label for="duration" class="col-form-label">مدة السؤال:</label>
                                <input type="number" min="5" max="60" placeholder="بالثواني" value="30"
                                       class="form-control" id="duration" name="duration">
                            </div>
                            <div class="form-group">
                                <label for="content" class="col-form-label">محتوى السؤال:</label>
                                <textarea placeholder="نص" class="form-control" id="content" name="content"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                            <button type="submit" class="btn btn-primary">اضافة</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--edit model-->
        @foreach($questions as $question)
            <div class="modal fade" id="editFormModel{{$question->id}}" tabindex="-1"
                 aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="/question/{{$question->id}}" method="post">
                            @csrf
                            @method('PATCH')
                            <div class="modal-body">
                                <input hidden name="id" value="{{$question->id}}">
                                <input hidden name="form_id" value="{{$form->id}}">
                                <div class="form-group">
                                    <label for="title" class="col-form-label">عنوان السؤال:</label>
                                    <input type="text" placeholder="نص" class="form-control" id="title" name="title"
                                           value="{{$question->title}}">
                                </div>
                                <div class="form-group">
                                    <label for="duration" class="col-form-label">مدة السؤال:</label>
                                    <input type="number" min="5" max="60" placeholder="بالثواني"
                                           value="{{$question->duration}}"
                                           class="form-control" id="duration" name="duration">
                                </div>
                                <div class="form-group">
                                    <label for="content" class="col-form-label">محتوى السؤال:</label>
                                    <textarea placeholder="نص" class="form-control" id="content" name="content"
                                              >{{$question->content}}</textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                                <button type="submit" class="btn btn-primary">تعديل</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    @endforeach
@endsection
