<?php
defined('_JEXEC') or die;
if (version_compare(JVERSION, '4.0', 'ge'))
{
	$FieldsHelper = new Joomla\Component\Fields\Administrator\Helper\FieldsHelper;
}
?>
<div>
	<?php if (empty($list)) : ?>
		<p>No items to show.</p>
	<?php endif; ?>

	<?php foreach ($list as $item) : ?>

		<?php
		// Get the value from custom fields
		if (version_compare(JVERSION, '4.0', 'ge'))
		{
			$jcFields = $FieldsHelper::getFields('com_content.article', $item, true);
		}
		else
		{
			$jcFields = FieldsHelper::getFields('com_content.article', $item, true);
		}
		$jcFields_arr = array();
		foreach ($jcFields as $jcField) {
			$jcFields_arr[$jcField->name] = $jcField->rawvalue;
		}

		// get the datetime in correct joomla! time offset
		$sansimera_datetime = isset($jcFields_arr['sansimera-datetime']) ? $jcFields_arr['sansimera-datetime'] : '';
		$sansimera_datetime_custom_format = JHTML::_("date", $sansimera_datetime, "d-M-Y");

		// Get image
		$image = json_decode($item->images);
		$image_alt = $value = htmlspecialchars($item->title, ENT_QUOTES, 'UTF-8');

		if (!empty($image->image_intro))
		{
			$image_src_intro = $image->image_intro;
			$image_alt = (!empty($image->image_intro_alt)) ? $image->image_intro_alt : $image_alt;
		}
		
		if (!empty($image->image_fulltext))
		{
			$image_src_full	= $image->image_fulltext;
			$image_alt = (!empty($image->image_fulltext_alt)) ? $image->image_fulltext_alt : $image_alt;
		}

		if (!empty($image->image_intro))
		{
			$image = $image_src_intro;
		}
		elseif (!empty($image->image_fulltext))
		{
			$image = $image_src_full;
		}
		else
		{
			$image = '';
		}
		?>

		<div style="border: 1px solid #ccc; padding: 20px; margin-bottom: 20px;">
			<h4>
				<?php echo $item->title; ?>
			</h4>
			<?php if(!empty($image)): ?>
			<div>
				<img width="200" src="<?php echo $image_src_full; ?>" alt="<?php echo $image_alt; ?>">
			</div>
			<?php endif; ?>
			<div>
				<small><?php echo $sansimera_datetime_custom_format; ?></small>
			</div>
			<div>
				<p>
					<?php echo $item->introtext; ?>
				</p>
			</div>
		</div>
	<?php endforeach; ?>
</div>
