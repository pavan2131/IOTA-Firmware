<?php
$title = "Load Project Configuration";
include 'header.php';
is_logged_in();
include 'sidebar.php';


$project = $rtdb->getReference(session('google_id'))->getSnapshot()->getValue()[get('project')] ?? [];


$element_types = [
    "button" => "Button",
    "slider" => "Slider",
    "display" => "Display",
    "line_graph" => "Line Graph",
    "bar_graph" => "Bar Graph",
    "pie_chart" => "Pie Chart",
    "linear_regression" => "Linear Regression",
    "logistic_regression" => "Logistic Regression",
    "line_extended_graph" => "Line Extended Graph",
    "voice_recognition" => "Voice Recognition"
];

$pin_functions = $project['config'] ?? [];
$project_config =[];
$res=$conn->query("select * from project_config where project_id='".$project['info']['project_id']."' and user_id='".session('google_id')."'");
$project_config = $res->fetch_assoc();
$project_config = json_decode($project_config['project_schema'],true) ?? [];

if(isset($_POST['submit']))
{
    $main_config = [];
    extract(post());
    for($i=0;$i<count($element_name);$i++)
    {
        $main_config[$element_name[$i]] = [
            "id"=>md5($element_name[$i]),
            "name"=>$element_name[$i],
            "type"=>$element_type[$i],
            "status"=>$element_status[$i],
            "function"=>$element_function[$i]
        ];
    }
    $rtdb->getReference(session('google_id')."/".$project['info']['project_id']."/hw_config")->set($main_config);

    //check if project is already created in database or not
    
    if($res->num_rows>0)
    {
            

        $update=$conn->query("update project_config set project_schema='".json_encode($main_config)."' where project_id='".$project['info']['project_id']."' and user_id='".session('google_id')."'");
        if($update)
        {  
            scr_red('LoadProjectConfiguration.php?'.http_build_query([
                'project'=>$project['info']['project_id'],
                'success'=>'Project Configuration Saved Successfully'
            ]));
        }
        else
        {
            scr_red('LoadProjectConfiguration.php?'.http_build_query([
                'project'=>$project['info']['project_id'],
                'error'=>'Something went wrong'
            ]));
        }
    }
    else
    {
        $insert=$conn->query("insert into project_config (user_id,project_id,project_schema) values ('".session('google_id')."','".$project['info']['project_id']."','".json_encode($main_config)."')");
        if($insert)
        {
            scr_red('LoadProjectConfiguration.php?'.http_build_query([
                'project'=>$project['info']['project_id'],
                'success'=>'Project Configuration Saved Successfully'
            ]));
        }
        else
        {
            scr_red('LoadProjectConfiguration.php?'.http_build_query([
                'project'=>$project['info']['project_id'],
                'error'=>'Something went wrong'
            ]));
        }
    }


}

if(get('success'))
{
    success(get('success'));
}else if(get('error')){
    error(get('error'));
}

?>

<div class="card m-4">
    <div class="card-header bg-warning border-1 border-warning">
        <h3 class="text-dark font-weight-bolder">
            <?= $project['info']['name'] ?>
        </h3>
        <hr>
        <h5 class="text-dark font-weight-bolder">
            <?= $project['info']['description'] ?>
        </h5>
    </div>
    <div class="card-body">
        <b class="float-start">
            Project ID : <?= $project['info']['project_id'] ?>
        </b>
        <b class="float-end">
            <button class="btn btn-primary" onclick="addElement()">Add Element</button>
        </b>
        <br>
        <div class="table-responsive p-2">
            <form action="" method="post" onsubmit="return confirm('Are you sure you want to save this configuration?')">
                <table class="table table-bordered table-hover ">
                    <thead>
                        <tr class="bg-primary text-white">
                            <th>Element Name</th>
                            <th>Element Type</th>
                            <th>Element Status</th>
                            <th>Element Function Code</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody id="ConfigData">
                        

                    
                        <?php 
                            if($project_config){
                                foreach($project_config as $cnf){
                                    ?>
                                        <tr>
                                            <td>
                                                <input type="text" class="form-control" placeholder="Element Name" name="element_name[]" value="<?= $cnf['name'] ?>">
                                            </td>
                                            <td>
                                                <select  class="form-control" name="element_type[]">
                                                    <option value="">Select Type</option>
                                                    <?php foreach ($element_types as $key => $val) : ?>
                                                        <option value="<?= $key ?>" <?= $key == $cnf['type'] ? 'selected' : '' ?>><?= $val ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </td>
                                            <td>
                                                <select  class="form-control" name="element_status[]">
                                                    <option value="">Select Status</option>
                                                    <option value="true" <?= $cnf['status'] == 'true' ? 'selected' : '' ?>>True</option>
                                                    <option value="false" <?= $cnf['status'] == 'false' ? 'selected' : '' ?>>False</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-control" name="element_function[]">
                                                    <option value="">Select Function</option>
                                                    <?php foreach ($pin_functions as $key => $val) : ?>
                                                        <option value="<?= $key ?>" <?= $key == $cnf['function'] ? 'selected' : '' ?>><?= $key ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </td>
                                            <td>
                                                <button class="btn btn-danger" onclick="deleteElement(this)" type="button" name="delete">Delete</button>
                                            </td>
                                        </tr>

                                    <?php
                                }
                            }


                        ?>

                    </tbody>
                </table>
                <br>
                <button class="btn btn-warning" type="submit" name="submit">Save Configuration</button>
            </form>
        </div>
    </div>
</div>

<script>
    addElement = () => {

        let main = `
            <tr>
                <td>
                    <input type="text" class="form-control" placeholder="Element Name" name="element_name[]">
                </td>
                <td>
                    <select  class="form-control" name="element_type[]">
                        <option value="">Select Type</option>
                        <?php foreach ($element_types as $key => $val) : ?>
                            <option value="<?= $key ?>"><?= $val ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td>
                    <select  class="form-control" name="element_status[]">
                        <option value="">Select Status</option>
                        <option value="true">True</option>
                        <option value="false">False</option>
                    </select>
                </td>
                <td>
                    <select  class="form-control" name="element_function[]">
                        <option value="">Select Function</option>
                        <?php foreach ($pin_functions as $key => $val) : ?>
                            <option value="<?= $key ?>"><?= $key ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td>
                    <button class="btn btn-danger" onclick="deleteElement(this)" type="button" name="delete">Delete</button>
                </td>
            </tr>
            `;

        $('#ConfigData').append(main);

    }

    deleteElement = (e)=>{
        if(confirm("Are you sure to delete this element ?")){
            $(e).parent().parent().remove();
        }
    }
</script>

<?php



include 'footer.php';
