<!-- Your HTML/PHP Code -->
<div class="col-lg-10 text-center aos-init aos-animate" data-aos="fade-up" data-aos-delay="0">
    <h2 class="line-bottom text-center mb-4">Departments of BSMMC</h2>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div id="navbarNav">
            <ul class="navbar-nav">
                <?php foreach ($departments as $department) : ?>
                    <?php if ($department->parent_department === null) : ?>
                        <li class="nav-item" data-target="<?= h($department->department_name) ?>">
                            <a class="nav-link btn btn-outline-primary btn-block" href="#"><?= h($department->department_name) ?></a>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </div>
    </nav>

    <p>List of all departments of Bangabandhu Sheikh Mujib Medical College, Faridpur</p>
</div>
</div>

<div class="row my-5">
    <div class="col-md-3">
        <?php foreach ($departments as $department) : ?>
            <div id="<?= h($department->department_name) ?>" class="mt-3 department-div">
                <div class="list-group">
                    <?php foreach ($department->children as $child) : ?>
                        <?php if ($child->children) : ?>
                            <a href="#submenu<?= h($child->department_id) ?>" class="list-group-item dropdown_root" data-toggle="collapse"><?= h($child->department_name) ?></a>
                            <div class="collapse" id="submenu<?= h($child->department_id) ?>">
                                <?php foreach ($child->children as $subChild) : ?>
                                    <?php
                                    debug($subChild);
                                    ?>
                                    <a href="#" class="list-group-item nested-list" data-department-id="<?= h($subChild->department_id) ?>"><?= h($subChild->department_name) ?></a>
                                <?php endforeach; ?>
                            </div>
                        <?php else : ?>
                            <a href="#" class="list-group-item" data-department-id="<?= h($child->department_id) ?>"><?= h($child->department_name) ?></a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Display Employee List -->
    <div class="col-md-9" id="employee-list-container">
        <!-- Employee list will be dynamically loaded here -->
    </div>
</div>

<!-- Add this section to your HTML file -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {
        // Hide all department divs initially
        $(".department-div").hide();

        // Add the "active" class to the first nav-item by default
        $(".navbar-nav .nav-item:first-child").addClass("active");

        // Show the selected department div
        $(".department-div:first").show();

        // Show the selected department div when a nav-item is clicked
        $(".nav-link").click(function(e) {
            e.preventDefault();

            // Get the data-department-id attribute value
            var department_id = $(this).data("department-id");
            console.log(department_id);
            // Hide all department divs
            $(".department-div").hide();

            // Remove "active" class from all nav-items
            $(".nav-link").removeClass("active");

            // Show the selected department div
            $("#" + department_id).show();

            // Add "active" class to the clicked nav-item
            $(this).addClass("active");

            // Fetch and display the employee list for the selected department
            loadEmployeeList(department_id);
        });

        // Load employee list for the default department on page load
        var defaultDepartmentId = $(".nav-link:first").data("department-id");
        loadEmployeeList(defaultDepartmentId);
    });

    function loadEmployeeList(department_id) {
        // Make an AJAX request to fetch the employee list for the selected department
        $.ajax({
            url: 'getEmployeesAjax', // Replace with the actual URL of your CakePHP controller action
            cache: false,
            type: 'GET',
            dataType: 'HTML',
            data: {
                "department_id": department_id
            },
            success: function(response) {
                // Display the employee list in the designated container
                $("#employee-list-container").html(response);
            },
            error: function(error) {
                console.error('Error fetching employee list:', error);
            }
        });
    }
</script>
