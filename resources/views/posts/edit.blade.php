@extends('layouts.app')

@section('title', '|Edit Post')

@section('content')
<div class="edit-post" style="margin-top: 100px;">
  <div class="edit-post-left">
    <div class="col-md-12">
      <i class="fa fa-calendar" aria-hidden="true"></i> Created At: {{ $post->created_at}}
    </div>
    <div class="col-md-12">
      <i class="fa fa-calendar" aria-hidden="true"></i> Updated At:  {{ $post->updated_at}}
    </div>
    <div class="col-md-12">
      <i class="fa fa-comments" aria-hidden="true"></i>{{-- {{(if no of comments 0, "No Comments Yet", else show no of comments) }}--}}No Of Comments:
    </div>
  </div>

  <div class="edit-post-right" style="padding: 20px;">
    {!! Form::model($post, ['route' =>['posts.update', $post->id], 'class'=> 'form-horizontal', 'method' => 'put', 'files' => true]) !!}

      <div class="col-md-12 form-input-space">
      {{ Form::text('title', null, ['class' => 'form-control form-title', 'required' => '', 'value' => old('title'),  'placeholder' => 'Title: ', 'minlength' => '5', 'maxlength' => '255']) }}
        @if($errors->has('title'))
          <span class="help-block danger">
            <strong>
              @foreach($errors->get('title') as $error)
                {{ $error }}
              @endforeach
            </strong>
          </span>
        @endif
      </div>

      <div class="col-md-12 form-input-space">
      {{ Form::text('slug', null, ['class' => 'form-control form-slug', 'required' => '', 'value' => old('slug'),  'placeholder' => 'Slug: ', 'minlength' => '5', 'maxlength' => '255']) }}
        @if($errors->has('slug'))
          <span class="help-block danger">
            <strong>
              @foreach($errors->get('slug') as $error)
                {{ $error }}
              @endforeach
            </strong>
          </span>
        @endif
      </div>

    <div class="col-md-12 form-input-space">
      {{ Form::textarea('body', null, ['class' => 'form-control', 'value' => old('body'), 'placeholder' => 'Body: ']) }}
      @if($errors->has('body'))
        <span class="help-block danger">
          <strong>{{ $errors->first('body') }}</strong>
        </span>
      @endif
    </div>

    @if($post->image)
    <div class="col-md-12">
        <img class="img" src={{ asset("images/posts/$post->image") }} width="100%" />
    </div>
    @endif

    <div class="col-md-12 form-input-space">
      <div class="col-md-8 post-image-modal">
        <p class="add-post-img"><i class="fa fa-plus-circle fa-lg" aria-hidden="true"></i> {{$post->image ? "Change Image" : "Add Image"}}</p>

        @if($errors->has('image'))
          <span class="help-block danger">
            <strong>{{ $errors->first('image') }}</strong>
          </span>
        @endif
      </div>

      <div class="col-md-3 col-md-offset-1" style="text-align: center; margin-top:11px;">
        {{ Form::submit('Update Post', ['class' => 'btn btn-primary btn-block']) }}
      </div>
    </div>

    {!! Form::close() !!}
  </div>
</div>

@endsection
