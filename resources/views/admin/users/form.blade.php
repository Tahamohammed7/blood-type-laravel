
<div class="form-group">
    <label for="name">Name</label>
    {!! Form::text('name',null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    <label for="email">Email</label>
    {!! Form::email('email',null,['class' => 'form-control']) !!}
</div>
<div class="form-group">
    <label for="password">Password</label>
   {!! Form::password('password', ['class' => 'form-control']) !!}
</div>
<div class="form-group">
        <strong>Role:</strong>
        {!! Form::select('roles[]', $roles,[], array('class' => 'form-control','multiple')) !!}
    </div>
<div class="form-group">
    <button class="btn btn-primary" type="submit">Submit</button>
</div>
