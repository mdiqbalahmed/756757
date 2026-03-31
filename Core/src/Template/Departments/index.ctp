<style>
    .custom_emp_card {
        background-color: transparent;
        justify-content: space-between;
        flex-direction: unset;
        border: none;

    }

    .custom_emp_card .col-md-5 {
        max-width: 48.5%;
    }

    .emp_card_body {
        background-color: #f5f5f5;
    }

    .emp_card_body h5 {
        font-size: 1em;
        font-weight: 500;
    }

    .emp_card_body i,
    .emp_card_body span {
        font-size: 0.75em;
        font-weight: 400;
    }

    .emp_card_body i.emp_degree {
        display: block;
        font-weight: 600;
        text-decoration: none;
        font-style: normal;
    }
</style>
<?php
// pr($departments);
// echo "<hr>";
// pr($employees);
// die;
?>
<div class="untree_co-section">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-10 text-center aos-init aos-animate" data-aos="fade-up" data-aos-delay="0">
                <h2 class="line-bottom text-center mb-4">Departments of BSMMC</h2>
                <nav class="navbar navbar-expand-lg navbar-light">
                    <div id="navbarNav">
                        <ul class="navbar-nav">
                            <?php foreach ($departments as $department) : ?>
                                <?php if ($department->parent_department === null) : ?>
                                    <li class="nav-item" data-target="<?= h($department->department_name) ?>">
                                        <a class="nav-link btn btn-outline-primary btn-block" href="javascript:void(0)"><?= h($department->department_name) ?></a>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </nav>
                <p class="mt-3">List of all departments of M Abdur Rahim Medical Collge, Dinajpur.</p>
            </div>
        </div>



        <div class="row my-5">
            <div class="col-md-3">
                <?php foreach ($departments as $department) : ?>
                    <div id="<?= h($department->department_name) ?>" class="department-div">
                        <div class="list-group">
                            <?php foreach ($department->children as $child) : ?>
                                <?php if ($child->children) : ?>
                                    <a href="#submenu<?= h($child->department_id) ?>" class="list-group-item dropdown_root" data-toggle="collapse"><?= h($child->department_name) ?></a>
                                    <div class="collapse" id="submenu<?= h($child->department_id) ?>">
                                        <?php foreach ($child->children as $subChild) : ?>
                                            <a href="javascript:void(0)" class="list-group-item nested-list" data-department-id="<?= h($subChild->department_id) ?>"><?= h($subChild->department_name) ?></a>
                                        <?php endforeach; ?>
                                    </div>
                                <?php else : ?>
                                    <a href="javascript:void(0)" class="list-group-item" data-department-id="<?= h($child->department_id) ?>"><?= h($child->department_name) ?></a>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="col-md-9">
                <div class="row card custom_emp_card" id="employee-list-container">
                    <?php foreach ($employees as $employee) : ?>
                        <div class="col-md-5 card-body emp_card_body mb-3">
                            <a href="<?php echo $this->Url->build(['controller' => 'Departments', 'action' => 'employeesProfile', $employee['employee_id']]) ?>">
                                <div class="row">
                                    <div class="col-md-3">
                                        <?php echo $this->Html->image("/webroot/uploads/employee_images/regularSize/" . $employee['image_name'], array("alt" => $employee['name'])); ?>
                                    </div>
                                    <div class="col-md-9">
                                        <h5><?= $employee['name'] ?></h5>
                                        <p>
                                            <?php if (isset($employee['degree'])) { ?>
                                            <i class="emp_degree"><?= $employee['degree'] ?></i>
                                            <?php }?>
                                            <i><?= $employee['designation'] ?></i>
                                            <span style="display:block"><?= $employee['job_institute'] ?></span>
                                            <span style="display:block"><?= $employee['email'] ?></span>
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {

        // Hide all department divs initially
        $(".department-div").hide();

        // Add the "active" class to the first nav-item by default
        $(".Navbar-nav .nav-item:first-child").addClass("active");

        // Show the first department div by default
        $("#Pre-Clinical").show();

        // Show the selected department div when a nav-item is clicked
        $(".nav-item").click(function() {
            // Get the data-target attribute value
            var target = $(this).data("target");

            // Hide all department divs
            $(".department-div").hide();

            // Remove "active" class from all nav-items
            $(".nav-item").removeClass("active");

            // Show the selected department div
            $("#" + target).show();

            // Add "active" class to the clicked nav-item
            $(this).addClass("active");

        });


        $('.list-group-item').on('click', function() {

            var departmentId = $(this).data('department-id');

            // Remove "active" class from all list-group-items
            $('.list-group-item').removeClass('active');

            // Add "active" class to the clicked list-group-item
            $(this).addClass('active');

            $.ajax({
                url: 'getEmployeesAjax', // Replace with the actual URL of your CakePHP controller action
                cache: false,
                type: 'GET',
                dataType: 'json', // Set the expected data type to JSON
                data: {
                    "department_id": departmentId
                },
                success: function(response) {
                    // Assuming response is an array of employees
                    var employeeListContainer = $('#employee-list-container');
                    employeeListContainer.empty(); // Clear existing content

                    if (response.length > 0) {
                        // Iterate through the employee data and append HTML to the container
                        $.each(response, function(index, employee) {
                            var employeeCard = $('<div class="col-md-5 card-body emp_card_body mb-3">').append(
                                $('<a href="<?php echo $this->Url->build(['controller' => 'Departments', 'action' => 'employeesProfile', 'employee_id' => '']) ?>/' + employee.employee_id + '">').append(
                                    '<div class="row">\
                                    <div class="col-md-3">\
                                        <img src="webroot/uploads/employee_images/regularSize/' + employee.image_name + '" width="100%" alt="">\
                                    </div>\
                                    <div class="col-md-9">\
                                        <h5>' + employee.name + '</h5>\
                                        <p>\
                                            <i class="emp_degree">' + employee.degree + '</i>\
                                            <i>' + employee.designation + '</i>\
                                            <span style="display:block">' + employee.job_institute + '</span>\
                                            <span style="display:block">' + 'Email: ' + '' + employee.email + '</span>\
                                        </p>\
                                    </div>\
                                </div>\
                            </div>')
                            );

                            employeeListContainer.append(employeeCard);
                        });
                    } else {
                        // Handle the case where no employees are returned
                        employeeListContainer.html('<p>No employees found for this department.</p>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching employee list. Status:', status);
                }
            });
        });
    });
</script>
