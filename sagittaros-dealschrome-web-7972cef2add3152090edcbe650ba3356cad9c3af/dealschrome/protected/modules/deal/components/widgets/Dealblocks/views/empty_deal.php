<?php
if ($suggestion) {
    $helper = new UrlHelper;
    $newUrl = $helper->mergeUrlQuery(array('query' => $suggestion))->newUrl;
}
?>

<div id="CannotFindDeal">
<div id="CannotFindDealDesc">We could not find the deal that you want.</div>

<?php if ($suggestion): ?>
    <br>
    <div id="CannotFindSuggestion">Did you mean <?php echo CHtml::link($suggestion, $newUrl); ?></a>?</div>

<?php endif; ?>
</div>