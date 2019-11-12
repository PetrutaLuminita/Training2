
<?php if (!empty($errors->get($fieldName))) : ?>
     <?php foreach ($errors->get($fieldName) as $message) : ?>
        <div class="help-is-danger">{{ __($message) }}</div>
    <?php endforeach ?>
<?php endif ?>

{{--@forelse ($errors->get($field_name) as $message)--}}
    {{--<p class="help-is-danger">{{ __($message) }}</p>--}}
{{--@empty--}}
{{--@endforelse--}}
