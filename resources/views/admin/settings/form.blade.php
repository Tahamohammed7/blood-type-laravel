
<div class="form-group">
    <label for="name">Notification Setting</label>
    {!! Form::text('notification_settings_text',null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    <label for="about_app">About App</label>
    {!! Form::text('about_app',null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    <label for="phone">Phone</label>
    {!! Form::text('phone',null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    <label for="email">Email</label>
   {!! Form::email('email', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    <label for="fb_link">fb_link</label>
    {!! Form::text('fb_link',null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    <label for="tw_link">tw_link</label>
    {!! Form::text('tw_link',null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    <label for="insta_link">insta_link</label>
    {!! Form::text('insta_link',null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    <label for="tube_link">tube_link</label>
    {!! Form::text('tube_link',null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    <label for="whats_link">whats_link</label>
    {!! Form::text('whats_link',null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    <button class="btn btn-primary" type="submit">Submit</button>
</div>
