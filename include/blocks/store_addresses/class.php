<?
use \Sotbit\Origami\Actions;
class Addresses extends Actions
{
	public function afterSaveContent()
	{
		\CBitrixComponent::clearComponentCache('sotbit:regions.maps','');
	}
	public function afterAdd()
	{
		\CBitrixComponent::clearComponentCache('sotbit:regions.maps', '');
	}
}
?>