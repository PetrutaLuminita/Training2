
<?php if (!empty($errors->get($field_name))) : ?>
     <?php foreach ($errors->get($field_name) as $message) : ?>
        <div class="help-is-danger">{{ __($message) }}</div>
    <?php endforeach ?>
<?php endif ?>

{{--@forelse ($errors->get($field_name) as $message)--}}
    {{--<p class="help-is-danger">{{ __($message) }}</p>--}}
{{--@empty--}}
{{--@endforelse--}}
