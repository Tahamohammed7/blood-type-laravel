
<div class="form-group">
    <label for="name">Title</label>
    {!! Form::text('title',null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    <label for="content">Content</label>
    {!! Form::text('content',null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    <label for="image">Image</label>
    {!! Form::file('image',null,['class' => 'form-control']) !!}
</div>
<div class="form-group">
    <button class="btn btn-primary" type="submit">Submit</button>
</div>
