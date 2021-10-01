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
		?>

		<div style="border: 1px solid #ccc; padding: 20px; margin-bottom: 20px;">
			<a style="font-size: 20px; font-weight: 700;" href="<?php echo $item->link; ?>">
				<?php echo $item->title; ?>
			</a>
			<div>
				<small><?php echo $sansimera_datetime_custom_format; ?></small>
			</div>
			<div>
				<p>
					<?php echo $item->introtext; ?>
				</p>
			</div>
			<div>
				<a class="btn button btn-primary uk-button" href="<?php echo $item->link; ?>">
					Διαβάστε περισσότερα
				</a>
			</div>
		</div>
	<?php endforeach; ?>
</div>
