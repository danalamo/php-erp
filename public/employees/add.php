<?php

require_once "../lib/helpers.php";

render([], function($data) {
    ?>
    <table>
        <thead></thead>
        <tbody></tbody>
    </table>
    <?php
    dd(relative_path(__FILE__));
});