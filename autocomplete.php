<?php 
include_once(__DIR__."/classes/c.dbh.php");
include_once(__DIR__."/classes/c.user.php");

$searchMatch = new User();

if(!empty($_POST["name"])) {

    // $searchMatch->setName($_POST["name"]);
    $query ="SELECT id, name FROM users WHERE name like '" . $_POST["name"] . "%' ORDER BY name LIMIT 0,6";
    $result = $searchMatch->searchMatch($query);

    if(!empty($result)) {
    ?>

    <form action="" method="post">

    <select multiple size="3" class="list-group mt-2 w-100 overflow-auto" name="selectReceiver">

        <?php
        foreach($result as $name) {
        ?>

        <option class="form-control pay-persons" onClick="selectName('<?php echo $name["name"]; ?>');" value="<?php echo $name['id'] ?>">
            <?php echo $name["name"]; ?>
        </option>
        
        <?php 
        } 
        ?>

    </select>

    
    </form>

    <?php 
    } 
}   
?>