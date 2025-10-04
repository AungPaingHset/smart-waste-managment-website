@extends("layouts.app")
@section("content")


<div class="container-fluid ">
  <div class="row justify-content-center">
    <div class="col-12 col-md-10 col-lg-8 col-xl-6">
      <div class="article-form-wrapper my-5 py-5">
        @if ($errors->any())
        <div class="alert alert-warning">
          @foreach($errors->all() as $err)
            {{ $err }}<br>
          @endforeach
        </div>
        @endif

        <form method="post">
          @csrf
          
          <div class="mb-2">
            <textarea name="body" class="form-control">{{ $article->body }}</textarea>
          </div>

          <div class="d-flex flex-column flex-sm-row gap-2">
            <button class="btn btn-primary flex-fill flex-sm-grow-0">Update Article</button>

            <a href="{{ url('/articles') }}" class="btn btm-primary flex-fill flex-sm-grow-0" style="display: inline-block;">
            ← Back to Articles
            </a>
          </div>
          
        </form>
      </div>
    </div>
  </div>
</div>
@endsection