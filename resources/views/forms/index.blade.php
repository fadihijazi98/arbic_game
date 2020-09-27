@extends('layouts.app')

@section('content')
    <div class="container" dir="rtl" style="text-align: right!important;">
        <div class="row justify-content-start">
            @if(session('success'))
            <div class="col-12 mt-2">
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>
            </div>
            @endif
            <div class="col-md-12 mt-4">
                <div class="card">
                    <div class="card-body">
                        <h4>
                            <a href="form/create" class="card-link">
                                +
                                انشاء نموذج جديد
                            </a>
                        </h4>
                    </div>
                </div>
            </div>
        <div hidden>{{$i=0}}</div>
        @foreach($forms as $form)

                <div class="col-md-4 col-sm-6 mt-4">
                    <div class="card {{((session('created') && $i++===0 && $j=1)?'bg-success':'border-dark')}} mb-3">
                        <div class="card-header">{{ $form->name }}</div>

                        <div class="card-body" style="height:100px;overflow: hidden">
                            <p class="card-text" ]>{{ $form->description }}</h3>
                        </div>

                        <div class="card-footer">
                           <form method="post" action="form/delete" class="d-inline">
                               @csrf
                               @method("DELETE")
                               <input name="id" value="{{$form->id}}" hidden>
                               <button class="btn btn-outline-danger">
                                   حذف
                               </button>
                           </form>
                            |
                            <form action="/form/{{$form->id}}/edit" class="d-inline">
                                <button class="btn btn-outline-{{((session('created') && $j++===1)?'light':'dark')}}">
                                    تعديل او اضافة اساله
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
