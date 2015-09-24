<?php
$this->breadcrumbs = array(
    'Php Test',
);
?>
<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>

<p>
    You may change the content of this page by modifying
    the file <tt><?php echo __FILE__; ?></tt>.
</p>

<?php
$options = array();
$options['success'] = 'function(data){console.log(data);}';
echo CHtml::ajax($options);

function echoHeredoc() {
    $str = <<<'EOD'
    Example of string
    spanning multiple lines
    using nowdoc syntax.
EOD;
    return $str;
}

d(echoHeredoc());

$ex = Keyword::model()->findByAttributes(array('term'=>'alcohol'));
d($ex);

$ex2 = Keyword::model()->findByAttributes(array('term'=>'alchol'));
d($ex2);
?>

