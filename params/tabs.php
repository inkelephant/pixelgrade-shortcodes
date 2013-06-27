<?php
$class= "span12";

if ( isset($param['admin_class'] ) ) $class = $param['admin_class']; ?>

<div class="<?php echo $class; ?> param-tabs" >
    <ul class="tabs-heads">
        <li data-index="1"><a href="#t1">Tab 1</a></li>
        <li data-index="0"><a href="#t-last">New Tab</a></li>
    </ul>
    <div id="t1" class="tab" data-tab="1">
        <p>Proin elit arcu, rutrum commodo, vehicula tempus, commodo a, risus. Curabitur nec arcu.</p>
        <p>Donec sollicitudin mi sit amet mauris. Nam elementum quam ullamcorper ante. Etiam aliquet massa et lorem.</p>
    </div>
    <div id="t-last" class="tab" data-tab="1">
        <p>Plast</p>
    </div>
</div>
<input type="hidden" name="<?php echo $param['param_key'] ?>" />