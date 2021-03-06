<?php foreach ($options['items'] as $key => $radio) : ?>
<div class="radio">
    <label for="<?= $widgetClassName . '_' . $token . '_' . $name ?>">
        <input type="radio"
               class="<?= $element ?> <?= $name ?><?php if (isset($options['classes'])) : ?> <?= $options['classes'] ?><?php endif; ?>"
               id="<?= $widgetClassName . '_' . $token . '_' . $name ?>"
               name="<?= $name ?>"
               value="<?= $key ?>"
               <?php if (isset($onchange)) : ?>onchange='<?= $onchange ?>'<?php endif; ?>
               <?php if ($params[$name] == $key) { ?>checked="checked" <?php } ?>
               data-for="<?= $widgetBaseClassName ?>_<?= $widgetClassName ?>_<?= $token ?>"
            <?php if ($options['disabled']) : ?> disabled="disabled"<?php endif; ?>
            <?php if ($options['readonly']) : ?> readonly="readonly" <?php endif; ?>>
        <?= $radio ?>
    </label>
</div>
<?php endforeach; ?>