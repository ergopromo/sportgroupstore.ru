<?
use \Sotbit\Origami\Actions;
class OfferForm extends Actions
{
    public function afterSaveContent()
    {
        \CBitrixComponent::clearComponentCache('bitrix:form.result.new','');
    }
    public function afterAdd()
    {
        \CBitrixComponent::clearComponentCache('bitrix:form.result.new', '');
    }
}
?>
