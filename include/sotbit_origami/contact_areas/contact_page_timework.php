<?if (isset($_SESSION["SOTBIT_REGIONS"]["UF_WORKING_MODE"])):?>

<?=$_SESSION["SOTBIT_REGIONS"]["UF_WORKING_MODE"]?>
<?else:?>
    <div>Режим работы:</div>
    <div>Пн-Пт: с 8.00 до 20.00</div> 

<?endif;?>