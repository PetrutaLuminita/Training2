<?php
    /** @var  \Illuminate\Support\ViewErrorBag $errors*/
    /** @var string $fieldName */
    /** @var \Illuminate\Support\MessageBag $message */
?>

<?php if (!empty($errors->get($fieldName))) : ?>
     <?php foreach ($errors->get($fieldName) as $message) : ?>
        <div class="help-is-danger">{{ $message }}</div>
    <?php endforeach ?>
<?php endif ?>

