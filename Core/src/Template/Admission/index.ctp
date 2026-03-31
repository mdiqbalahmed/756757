<?php

$this->Form->unlockField('gsa_id');
?>
<?php

use Cake\Core\Configure;

$main_top_bg = Configure::read('Menu.main_top_bg');
$main_bottom_bg = Configure::read('Menu.main_bottom_bg');
$main_text_color = Configure::read('Menu.main_text_color');
$main_border_color = Configure::read('Menu.main_border_color');
$submenu_top_bg = Configure::read('Menu.submenu_top_bg');
$submenu_bottom_bg = Configure::read('Menu.submenu_bottom_bg');
$submenu_text_color = Configure::read('Menu.submenu_text_color');

?>
<?php $this->assign('title', 'Admission Form'); ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f0f0f0;
    }



    .form-container {
        background-color: #b3b3b3;
        padding: 15px;
        width: 90%;
        margin: 24px auto;
        border-radius: 0px;
    }

    .form-label {
        font-size: 14px;
        /* color: #4d773c; */
        color: rgb(20 28 26);
        margin-bottom: 5px;
    }

    .form-label span {
        color: red;
    }

    .form-input {
        width: 80%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 14px;
    }

    .form-button {
        margin-top: 10px;
        background-color: #996515;
        color: white;
        border: none;
        padding: 10px 20px;
        font-size: 16px;
        border-radius: 4px;
        cursor: pointer;
    }

    .form-button:hover {
        background-color: #804a10;
    }

    .form-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .input-container {
        flex-grow: 1;
        margin-right: 10px;
    }
</style>

<?php if (!isset($stu)) {
    $this->layout = 'default'; ?>
    <div class="container">
        <div class="header">
            <p class="text-center" style="color: #2f5500; margin-right: 209px; font-size: 25px;">
                <?= __d('students', 'নিচে ফর্ম পূরণ করে Search Button টী চাপুন :') ?>
            </p>
        </div>

        <!-- Start the CakePHP Form -->
        <?= $this->Form->create(null, ['type' => 'file', 'url' => ['action' => 'index']]) ?>

        <div class="form-container">
            <div class="form-row">
                <div class="input-container">
                    <!-- Label for GSA User ID -->
                    <?= $this->Form->label('gsa_id', 'GSA User ID <span>*</span>', ['escape' => false, 'class' => 'form-label', 'style' => 'font-size: 14px; color: #4d773c;']) ?>
                    <!-- Input Field -->
                    <?= $this->Form->control('gsa_id', [
                        'label' => false,
                        'type' => 'text',
                        'placeholder' => 'Enter GSA User ID',
                        'class' => 'form-input',
                        'required' => true,
                    ]) ?>
                </div>
                <!-- Search Button -->
                <?= $this->Form->button(__('SEARCH'), [
                    'type' => 'submit',
                    'class' => 'form-button',

                ]) ?>
            </div>
        </div>

        <!-- End the CakePHP Form -->
        <?= $this->Form->end() ?>
    </div>

<?php   } ?>



<?php if (isset($stu)) {

    $this->layout = 'no_sidebar';

    $this->Form->unlockField('id');
    $this->Form->unlockField('name_english');
    $this->Form->unlockField('name_bangla');
    $this->Form->unlockField('gsa_id');
    $this->Form->unlockField('bn_fname');
    $this->Form->unlockField('bn_mname');
    $this->Form->unlockField('gender');
    $this->Form->unlockField('mobile');
    $this->Form->unlockField('fname');
    $this->Form->unlockField('foccupation_type');
    $this->Form->unlockField('f_nid');
    $this->Form->unlockField('image_name');
    $this->Form->unlockField('foccupation');
    $this->Form->unlockField('fincome');
    $this->Form->unlockField('fmobile');
    $this->Form->unlockField('mname');
    $this->Form->unlockField('nid');
    $this->Form->unlockField('m_nid');
    $this->Form->unlockField('moccupation_type');
    $this->Form->unlockField('moccupation');
    $this->Form->unlockField('present_address');
    $this->Form->unlockField('mincome');
    $this->Form->unlockField('mmobile');
    $this->Form->unlockField('dob');
    $this->Form->unlockField('birth_reg');
    $this->Form->unlockField('nationality');
    $this->Form->unlockField('blood_group');
    $this->Form->unlockField('religion');

    $this->Form->unlockField('permanent_address');
    $this->Form->unlockField('present_address');
    $this->Form->unlockField('pre_school');

    $this->Form->unlockField('permanent_house');
    $this->Form->unlockField('permanent_village');
    $this->Form->unlockField('permanent_district');
    $this->Form->unlockField('permanent_upazila');
    $this->Form->unlockField('permanent_post');
    $this->Form->unlockField('permanent_mouza');

    $this->Form->unlockField('present_village');
    $this->Form->unlockField('present_house');
    $this->Form->unlockField('present_district');
    $this->Form->unlockField('present_upazila');
    $this->Form->unlockField('present_post');
    $this->Form->unlockField('present_mouza');

    //Educational Information table => "scms_qualification"
    $this->Form->unlockField('exam_name');
    $this->Form->unlockField('exam_board');
    $this->Form->unlockField('passing_year');
    $this->Form->unlockField('exam_roll');
    $this->Form->unlockField('exam_gpa');
    $this->Form->unlockField('exam_reg');
    $this->Form->unlockField('sub_4th');
    $this->Form->unlockField('sub_3rd');
    $this->Form->unlockField('group');
    $this->Form->unlockField('session');

    //In Absence Of Parents
    $this->Form->unlockField('aname');
    $this->Form->unlockField('relation');
    $this->Form->unlockField('address');
    $this->Form->unlockField('other_house');
    $this->Form->unlockField('other_village');
    $this->Form->unlockField('other_district');
    $this->Form->unlockField('other_upazila');
    $this->Form->unlockField('other_post');
    $this->Form->unlockField('other_mouza');



    //Father Information table => "scms_qualification"
    $this->Form->unlockField('quota');
    $this->Form->unlockField('shift');
    // $this->Form->unlockField('roll');
    $this->Form->unlockField('level');
    $this->Form->unlockField('section');
    $this->Form->unlockField('class_roll');
    $this->Form->unlockField('thumbnail');
    $this->Form->unlockField('status');
    $this->Form->unlockField('student_status');
    $this->Form->unlockField('scholarship');
    $this->Form->unlockField('stipend');

    $this->Form->unlockField('serial');
    $this->Form->unlockField('stipend_id');
    $this->Form->unlockField('stipend_account');

?>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .form-control:focus {
            border-color: rgb(5, 90, 69);
            box-shadow: 0 0 5px rgba(76, 175, 80, 0.5);
        }

        .btn-success:hover {
            background-color: #45a049;
        }
    </style>




    <div class=" text-gray-800 text-sm max-w-6xl mx-auto  font-sans">

        <h2 class=" font-bold ">নিচে ফর্ম পূরণ করে Submit Button টি চাপুন :</h2>

        <!-- Basic Information Section -->
        <div class=" bg-white border border-gray-300 p-6 mb-6 mt-6">
            <div class=" bg-[<?= $main_top_bg ?>] text-white font-bold px-3 py-2 text-sm -mt-6 -mx-6 mb-4">
                Basic Information
            </div>
            <?php echo $this->Form->create('', ['type' => 'file']); ?>

            <input type="hidden" name="id" value="<?php echo $stu->id; ?>">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Left Side: Form Fields -->
                <div class="space-y-4">

                    <div class="flex flex-col md:flex-row md:items-center md:gap-3">
                        <label for="name" class="font-semibold block mb-1 md:mb-0 md:w-32">Student's Name</label>
                        <input type="text" name="name_english" value="<?php echo $stu->name_english; ?>" class="w-full md:flex-1 border border-black rounded px-2 py-1 text-sm" readonly required>
                    </div>

                    <div class="flex flex-col md:flex-row md:items-center md:gap-3">
                        <label for="name_bangla" class="font-semibold block mb-1 md:mb-0 md:w-32">Name (Bangla)</label>
                        <input type="text" name="name_bangla" class="w-full md:flex-1 border border-black rounded px-2 py-1 text-sm" required>
                    </div>
                    <div class="flex flex-col md:flex-row md:items-center md:gap-3">
                        <label for="gsa_id" class="font-semibold block mb-1 md:mb-0 md:w-32">GSA ID</label>
                        <input type="text" name="gsa_id" value="<?php echo $stu->gsa_id; ?>" class="w-full md:flex-1 border border-black rounded px-2 py-1 text-sm" readonly required>
                    </div>

                    <div class="flex flex-col md:flex-row md:items-center md:gap-3">
                        <label for="mobile" class="font-semibold block mb-1 md:mb-0 md:w-32">Mobile No</label>
                        <input type="tel" id="mobile" name="mobile" class="w-full md:flex-1 border border-black rounded px-2 py-1 text-sm" placeholder="01XXXXXXXXX" required>
                    </div>
                    <div class="flex flex-col md:flex-row md:items-center md:gap-3">
                        <label for="dob" class="font-semibold block mb-1 md:mb-0 md:w-32">Date of Birth</label>
                        <input type="date" name="dob" class="w-full md:flex-1 border border-black rounded px-2 py-1 text-sm">
                    </div>
                    <div class="flex flex-col md:flex-row md:items-center md:gap-3">
                        <label for="birth_reg" class="font-semibold block mb-1 md:mb-0 md:w-32">Birth Registration</label>
                        <input type="text" name="birth_reg" value="<?php echo $stu->birth_reg; ?>" class="w-full md:flex-1 border border-black rounded px-2 py-1 text-sm" readonly>
                    </div>
                    <div class="flex flex-col md:flex-row md:items-center md:gap-3">
                        <label for="religion" class="font-semibold block mb-1 md:mb-0 md:w-32">Religion</label>
                        <select type="text" name="religion" class="w-full md:flex-1 border border-black rounded px-2 py-1 text-sm" required>
                            <option value="">Select</option>
                            <option value="Islam">Islam</option>
                            <option value="Hindu">Hindu</option>
                            <option value="Christian">Christian</option>
                            <option value="Buddh">Buddh</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                </div>

                <!-- Right Side: Upload Image -->
                <div class="flex justify-center items-center py-4 gap-8">
                    <!-- Profile Image -->
                    <div class="w-36">
                        <img id="preview-image" src="/uploads/default.png" src="" alt="Upload Image"
                            class="w-full h-36 object-cover border-2 border-gray-300 shadow-md rounded-md" />

                        <label for="image-upload"
                            class="mt-2 block text-center bg-[<?= $main_top_bg ?>] text-white text-sm py-2 rounded cursor-pointer hover:bg-[<?= $submenu_top_bg ?>] transition duration-200">
                            <i class="fa fa-arrow-circle-up mr-1"></i>Upload Image
                        </label>

                        <input id="image-upload" name="thumbnail" required type="file" accept="image/*" class="hidden" />
                        <p class="text-xs text-gray-500 text-center mt-2">* Image size should be 300×300 pixels</p>
                    </div>
                </div>
            </div>

            <!-- Fields in 2 Columns on Desktop with Aligned Inputs -->
            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                <div class="flex flex-col md:flex-row md:items-center md:gap-3">
                    <label for="gender" class="font-semibold block mb-1 md:mb-0 md:w-32">Gender</label>
                    <select type="text" name="gender" class="w-full md:flex-1 border border-black rounded px-2 py-1 text-sm" required>
                        <option value="Female">Female</option>
                    </select>
                </div>

                <div class="flex flex-col md:flex-row md:items-center md:gap-3">
                    <label for="nid" class="font-semibold block mb-1 md:mb-0 md:w-32">Blood Group</label>
                    <select name="blood_group" id="blood_group"
                        class="w-full md:flex-1 border border-black rounded px-2 py-1 text-sm">
                        <option value="">-- Select --</option>
                        <option value="A+">A+</option>
                        <option value="A-">A-</option>
                        <option value="B+">B+</option>
                        <option value="B-">B-</option>
                        <option value="AB+">AB+</option>
                        <option value="AB-">AB-</option>
                        <option value="O+">O+</option>
                        <option value="O-">O-</option>
                    </select>
                </div>
                <div class="flex flex-col md:flex-row md:items-center md:gap-3">
                    <label for="nationality" class="font-semibold block mb-1 md:mb-0 md:w-32">Nationality</label>
                    <input type="text" name="nationality" class="w-full md:flex-1 border border-black rounded px-2 py-1 text-sm" required>
                </div>

                <div class="flex flex-col md:flex-row md:items-center md:gap-3">
                    <label for="gender" class="font-semibold block mb-1 md:mb-0 md:w-32">Previous School & Class </label>
                    <input type="text" name="pre_school" class="w-full md:flex-1 border border-black rounded px-2 py-1 text-sm" placeholder="SCHOOL NAME, CLASS NAME" required>
                </div>


            </div>

        </div>


        <!-- Address Section -->
        <div class=" ">
            <div class="flex flex-col md:flex-row gap-4 mb-6">
                <!-- Present Address -->
                <div class="flex-1 bg-white border border-gray-300 p-4 rounded-md order-1 md:order-1">
                    <div class="bg-[<?= $main_top_bg ?>] text-white font-bold px-3 py-2 rounded-t-md text-sm -mt-6 -mx-6 mb-4">
                        Present Address
                    </div>
                    <div class="grid grid-cols-1 gap-3">
                        <div class="flex flex-col md:flex-row md:items-center md:gap-3">
                            <label for="nationality" class="font-semibold block mb-1 md:mb-0 md:w-32">House No</label>
                            <input type="text" name="present_house" class="w-full md:flex-1 border border-black rounded px-2 py-1 text-sm" required>
                        </div>
                        <div class="flex flex-col md:flex-row md:items-center md:gap-3">
                            <label for="nationality" class="font-semibold block mb-1 md:mb-0 md:w-32">Village</label>
                            <input type="text" name="present_village" class="w-full md:flex-1 border border-black rounded px-2 py-1 text-sm" required>
                        </div>

                        <div class="flex flex-col md:flex-row md:items-center md:gap-3">
                            <label for="zila_id" class="font-semibold block mb-1 md:mb-0 md:w-32">District</label>
                            <select id="zila_id" name="present_district" class="w-full md:flex-1 border border-black rounded px-2 py-1 text-sm" required>
                                <option value="">Select</option>
                                <?php foreach ($zilas as $zila) { ?>
                                    <option value="<?= htmlspecialchars($zila['name']) ?>"
                                        data-id="<?= (int)$zila['zila_id'] ?>">
                                        <?= htmlspecialchars($zila['name']) ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="flex flex-col md:flex-row md:items-center md:gap-3">
                            <label for="upazila_id" class="font-semibold block mb-1 md:mb-0 md:w-32">Thana/Upazila</label>
                            <select id="upazila_id" name="present_upazila" class="w-full md:flex-1 border border-black rounded px-2 py-1 text-sm" required>
                                <option value="">Select</option>
                                <?php foreach ($upazilas as $upazila) { ?>
                                    <option value="<?= htmlspecialchars($upazila['name']) ?>"
                                        data-zila="<?= (int)$upazila['zila_id'] ?>">
                                        <?= htmlspecialchars($upazila['name']) ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="flex flex-col md:flex-row md:items-center md:gap-3">
                            <label for="marital_status" class="font-semibold block mb-1 md:mb-0 md:w-32">Mouza</label>
                            <input type="text" name="present_mouza" class="w-full md:flex-1 border border-black rounded px-2 py-1 text-sm" required>
                        </div>
                        <div class="flex flex-col md:flex-row md:items-center md:gap-3">
                            <label for="marital_status" class="font-semibold block mb-1 md:mb-0 md:w-32">Post Office</label>
                            <input type="text" name="present_post" class="w-full md:flex-1 border border-black rounded px-2 py-1 text-sm" required>
                        </div>

                    </div>
                </div>

                <!-- Permanent Address -->
                <div class="flex-1 bg-white border border-gray-300 p-4 rounded-md order-2 md:order-2">
                    <div class="flex justify-between items-center bg-[<?= $main_top_bg ?>] text-white font-bold px-3 py-2 rounded-t-md text-sm -mt-6 -mx-6 mb-4">
                        <span>Permanent Address</span>
                        <label class="text-xs font-normal flex items-center">
                            <input type="checkbox" id="sameAddress" class="mr-1"> Same as Present Address
                        </label>
                    </div>
                    <div class="grid grid-cols-1 gap-3">
                        <div class="flex flex-col md:flex-row md:items-center md:gap-3">
                            <label for="nationality" class="font-semibold block mb-1 md:mb-0 md:w-32">House No</label>
                            <input type="text" name="permanent_house" class="w-full md:flex-1 border border-black rounded px-2 py-1 text-sm" required>
                        </div>
                        <div class="flex flex-col md:flex-row md:items-center md:gap-3">
                            <label for="nationality" class="font-semibold block mb-1 md:mb-0 md:w-32">Village</label>
                            <input type="text" name="permanent_village" class="w-full md:flex-1 border border-black rounded px-2 py-1 text-sm" required>
                        </div>

                        <div class="flex flex-col md:flex-row md:items-center md:gap-3">
                            <label for="mobile" class="font-semibold block mb-1 md:mb-0 md:w-32">District</label>
                            <select id="zila_id_2" name="permanent_district" class="w-full md:flex-1 border border-black rounded px-2 py-1 text-sm" required>
                                <option value="">Select</option>
                                <?php foreach ($zilas as $zila) { ?>
                                    <option value="<?= htmlspecialchars($zila['name']) ?>"
                                        data-id="<?= (int)$zila['zila_id'] ?>">
                                        <?= htmlspecialchars($zila['name']) ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="flex flex-col md:flex-row md:items-center md:gap-3">
                            <label for="confirm_mobile" class="font-semibold block mb-1 md:mb-0 md:w-32">Thana/Upazila</label>
                            <select id="upazila_id_2" name="permanent_upazila" class="w-full md:flex-1 border border-black rounded px-2 py-1 text-sm" required>
                                <option value="">Select</option>
                                <?php foreach ($upazilas as $upazila) { ?>
                                    <option value="<?= htmlspecialchars($upazila['name']) ?>"
                                        data-zila="<?= (int)$upazila['zila_id'] ?>">
                                        <?= htmlspecialchars($upazila['name']) ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="flex flex-col md:flex-row md:items-center md:gap-3">
                            <label for="email" class="font-semibold block mb-1 md:mb-0 md:w-32">Mouza</label>
                            <input type="text" name="permanent_mouza" class="w-full md:flex-1 border border-black rounded px-2 py-1 text-sm" required>
                        </div>

                        <div class="flex flex-col md:flex-row md:items-center md:gap-3">
                            <label for="marital_status" class="font-semibold block mb-1 md:mb-0 md:w-32">Post Office</label>
                            <input type="text" name="permanent_post" class="w-full md:flex-1 border border-black rounded px-2 py-1 text-sm" required>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Father's Information-->
        <div class="bg-white border border-gray-300 p-6 mb-6 ">
            <div class="bg-[<?= $main_top_bg ?>] text-white font-bold px-3 py-2  text-sm -mt-6 -mx-6 mb-4">
                Father's Information
            </div>

            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                <div class="flex flex-col md:flex-row md:items-center md:gap-3">
                    <label for="date_of_birth" class="font-semibold block mb-1 md:mb-0 md:w-32">Name</label>
                    <input type="text" name="fname" value="<?php echo $stu->fname; ?>" class="w-full md:flex-1 border border-black rounded px-2 py-1 text-sm" readonly required>
                </div>

                <div class="flex flex-col md:flex-row md:items-center md:gap-3">
                    <label for="nid" class="font-semibold block mb-1 md:mb-0 md:w-32">Name (Bangla)</label>
                    <input type="text" name="bn_fname" class="w-full md:flex-1 border border-black rounded px-2 py-1 text-sm" required>
                </div>

                <div class="flex flex-col md:flex-row md:items-center md:gap-3">
                    <label for="gender" class="font-semibold block mb-1 md:mb-0 md:w-32">NID </label>
                    <input type="text" name="f_nid" class="w-full md:flex-1 border border-black rounded px-2 py-1 text-sm" required>
                </div>

                <div class="flex flex-col md:flex-row md:items-center md:gap-3">
                    <label for="religion" class="font-semibold block mb-1 md:mb-0 md:w-32"> Profession</label>
                    <input type="text" name="foccupation" class="w-full md:flex-1 border border-black rounded px-2 py-1 text-sm" required>
                </div>
                <div class="flex flex-col md:flex-row md:items-center md:gap-3">
                    <label for="religion" class="font-semibold block mb-1 md:mb-0 md:w-32"> Profession Type</label>
                    <select type="text" name="foccupation_type" class="w-full md:flex-1 border border-black rounded px-2 py-1 text-sm" v>
                        <option value="">Select</option>
                        <option value="Govt">Govt.</option>
                        <option value="Non Govt.">Non Govt.</option>
                        <option value="Others">Others</option>
                    </select>
                </div>

                <div class="flex flex-col md:flex-row md:items-center md:gap-3">
                    <label for="nationality" class="font-semibold block mb-1 md:mb-0 md:w-32">Yearly Income</label>
                    <input type="text" name="fincome" class="w-full md:flex-1 border border-black rounded px-2 py-1 text-sm" required>
                </div>

                <div class="flex flex-col md:flex-row md:items-center md:gap-3">
                    <label for="mobile" class="font-semibold block mb-1 md:mb-0 md:w-32">Mobile</label>
                    <input type="tel" id="mobile" name="fmobile" class="w-full md:flex-1 border border-black rounded px-2 py-1 text-sm" placeholder="01XXXXXXXXX" required>
                </div>


            </div>
        </div>

        <!-- SSC/Equivalent Level-->
        <div class="bg-white border border-gray-300 p-6 mb-6 ">
            <div class="bg-[<?= $main_top_bg ?>] text-white font-bold px-3 py-2  text-sm -mt-6 -mx-6 mb-4">
                Mother's Information
            </div>

            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                <div class="flex flex-col md:flex-row md:items-center md:gap-3">
                    <label for="date_of_birth" class="font-semibold block mb-1 md:mb-0 md:w-32">Name</label>
                    <input type="text" name="mname" value="<?php echo $stu->mname; ?>" class="w-full md:flex-1 border border-black rounded px-2 py-1 text-sm" readonly required>
                </div>

                <div class="flex flex-col md:flex-row md:items-center md:gap-3">
                    <label for="nid" class="font-semibold block mb-1 md:mb-0 md:w-32">Name (Bangla)</label>
                    <input type="text" name="bn_mname" class="w-full md:flex-1 border border-black rounded px-2 py-1 text-sm" required>
                </div>

                <div class="flex flex-col md:flex-row md:items-center md:gap-3">
                    <label for="gender" class="font-semibold block mb-1 md:mb-0 md:w-32">NID </label>
                    <input type="text" name="m_nid" class="w-full md:flex-1 border border-black rounded px-2 py-1 text-sm" required>
                </div>
                <div class="flex flex-col md:flex-row md:items-center md:gap-3">
                    <label for="religion" class="font-semibold block mb-1 md:mb-0 md:w-32"> Profession</label>
                    <input type="text" name="moccupation" class="w-full md:flex-1 border border-black rounded px-2 py-1 text-sm" required>
                </div>
                <div class="flex flex-col md:flex-row md:items-center md:gap-3">
                    <label for="religion" class="font-semibold block mb-1 md:mb-0 md:w-32"> Profession Type</label>
                    <select type="text" name="moccupation_type" class="w-full md:flex-1 border border-black rounded px-2 py-1 text-sm" required>
                        <option value="">Select</option>
                        <option value="Govt">Govt.</option>
                        <option value="Non Govt.">Non Govt.</option>
                        <option value="Others">Others</option>
                    </select>
                </div>

                <div class="flex flex-col md:flex-row md:items-center md:gap-3">
                    <label for="nationality" class="font-semibold block mb-1 md:mb-0 md:w-32">Yearly Income</label>
                    <input type="text" name="mincome" class="w-full md:flex-1 border border-black rounded px-2 py-1 text-sm" required>
                </div>

                <div class="flex flex-col md:flex-row md:items-center md:gap-3">
                    <label for="mobile" class="font-semibold block mb-1 md:mb-0 md:w-32">Mobile</label>
                    <input type="tel" id="mobile" name="mmobile" class="w-full md:flex-1 border border-black rounded px-2 py-1 text-sm" placeholder="01XXXXXXXXX" required>
                </div>
            </div>
        </div>

        <!-- HSC/Equivalent Level-->
        <div class="bg-white border border-gray-300 p-6 mb-6 ">
            <div class="bg-[<?= $main_top_bg ?>] text-white font-bold px-3 py-2 text-sm -mt-6 -mx-6 mb-4">
                In Absence Of Parents
            </div>

            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                <div class="flex flex-col md:flex-row md:items-center md:gap-3">
                    <label for="date_of_birth" class="font-semibold block mb-1 md:mb-0 md:w-32">Name(English)</label>
                    <input type="text" name="aname" class="w-full md:flex-1 border border-black rounded px-2 py-1 text-sm">
                </div>

                <div class="flex flex-col md:flex-row md:items-center md:gap-3">
                    <label for="nid" class="font-semibold block mb-1 md:mb-0 md:w-32">Relation</label>
                    <input type="text" name="relation" class="w-full md:flex-1 border border-black rounded px-2 py-1 text-sm">
                </div>

                <div class="flex flex-col md:flex-row md:items-center md:gap-3">
                    <label for="gender" class="font-semibold block mb-1 md:mb-0 md:w-32">House No</label>
                    <input type="text" name="other_house" class="w-full md:flex-1 border border-black rounded px-2 py-1 text-sm">
                </div>

                <div class="flex flex-col md:flex-row md:items-center md:gap-3">
                    <label for="religion" class="font-semibold block mb-1 md:mb-0 md:w-32"> Village</label>
                    <input type="text" name="other_village" class="w-full md:flex-1 border border-black rounded px-2 py-1 text-sm">
                </div>

                <div class="flex flex-col md:flex-row md:items-center md:gap-3">
                    <label for="mobile" class="font-semibold block mb-1 md:mb-0 md:w-32">District</label>
                    <select id="zila_id_3" name="other_district" class="w-full md:flex-1 border border-black rounded px-2 py-1 text-sm">
                        <option value="">Select</option>
                        <?php foreach ($zilas as $zila) { ?>
                            <option value="<?= htmlspecialchars($zila['name']) ?>"
                                data-id="<?= (int)$zila['zila_id'] ?>">
                                <?= htmlspecialchars($zila['name']) ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="flex flex-col md:flex-row md:items-center md:gap-3">
                    <label for="confirm_mobile" class="font-semibold block mb-1 md:mb-0 md:w-32">Thana/Upazila</label>
                    <select id="upazila_id_3" name="other_upazila" class="w-full md:flex-1 border border-black rounded px-2 py-1 text-sm">
                        <option value="">Select</option>
                        <?php foreach ($upazilas as $upazila) { ?>
                            <option value="<?= htmlspecialchars($upazila['name']) ?>"
                                data-zila="<?= (int)$upazila['zila_id'] ?>">
                                <?= htmlspecialchars($upazila['name']) ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="flex flex-col md:flex-row md:items-center md:gap-3">
                    <label for="nationality" class="font-semibold block mb-1 md:mb-0 md:w-32">Mouza</label>
                    <input type="text" name="other_mouza" class="w-full md:flex-1 border border-black rounded px-2 py-1 text-sm">
                </div>

                <div class="flex flex-col md:flex-row md:items-center md:gap-3">
                    <label for="nationality" class="font-semibold block mb-1 md:mb-0 md:w-32">Post</label>
                    <input type="text" name="other_post" class="w-full md:flex-1 border border-black rounded px-2 py-1 text-sm">
                </div>




            </div>
        </div>

        <!-- Graduation/Equivalent Level -->
        <div class="bg-white border border-gray-300 p-6 mb-6 ">
            <div class="bg-[<?= $main_top_bg ?>] text-white font-bold px-3 py-2 text-sm -mt-6 -mx-6 mb-4">
                Admission INFO
            </div>

            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                <div class="flex flex-col md:flex-row md:items-center md:gap-3">
                    <label for="nid" class="font-semibold block mb-1 md:mb-0 md:w-32">Class</label>
                    <input type="text" name="level" value="<?php echo $stu->level; ?>" class="w-full md:flex-1 border border-black rounded px-2 py-1 text-sm" readonly>
                </div>

                <div class="flex flex-col md:flex-row md:items-center md:gap-3">
                    <label for="session" class="font-semibold block mb-1 md:mb-0 md:w-32">Session</label>
                    <input type="number" name="session" id="session" value="2026" readonly class="w-full md:flex-1 border border-black rounded px-2 py-1 text-sm bg-gray-100">

                </div>


                <div class="flex flex-col md:flex-row md:items-center md:gap-3">
                    <label for="gender" class="font-semibold block mb-1 md:mb-0 md:w-32">Shift</label>
                    <input type="text" name="shift" value="<?php echo $stu->shift; ?>" class="w-full md:flex-1 border border-black rounded px-2 py-1 text-sm" readonly>
                </div>

                <div class="flex flex-col md:flex-row md:items-center md:gap-3">
                    <label for="scholarship" class="font-semibold block mb-1 md:mb-0 md:w-32"> Scholarship</label>
                    <select name="scholarship" id="scholarship" class="w-full md:flex-1 border border-black rounded px-2 py-1 text-sm">
                        <option value="">Select</option>
                        <option value="No">No</option>
                        <option value="PEC">PEC</option>
                        <option value="JSC">JSC</option>
                        <option value="JDC">JDC</option>

                    </select>
                </div>

                <div class="flex flex-col md:flex-row md:items-center md:gap-3">
                    <label for="quota" class="font-semibold block mb-1 md:mb-0 md:w-32">Quota</label>
                    <input type="text" name="quota" value="<?php echo $stu->quota; ?>" class="w-full md:flex-1 border border-black rounded px-2 py-1 text-sm" readonly>
                </div>

                <div class="flex flex-col md:flex-row md:items-center md:gap-3 mb-3">
                    <label for="stipend" class="font-semibold block mb-1 md:mb-0 md:w-32">Stipend</label>
                    <select id="stipendSelect" name="stipend"
                        class="w-full md:flex-1 border border-black rounded px-2 py-1 text-sm">
                        <option value="">Select</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                </div>

                <!-- Extra field (hidden by default) -->
                <div id="stipendNumberField" class="flex flex-col md:flex-row md:items-center md:gap-3 hidden">
                    <label for="stipend_number" class="font-semibold block mb-1 md:mb-0 md:w-32">Stipend Number</label>
                    <input type="text" id="stipend" name="stipend_id"
                        class="w-full md:flex-1 border border-black rounded px-2 py-1 text-sm"
                        placeholder="Enter stipend number">
                </div>
            </div>
        </div>




        <div class="flex items-center mb-4">
            <input type="checkbox" id="declarationCheckbox" class="mr-2">
            <label for="declarationCheckbox" class="text-sm"> আমি এই মর্মে ঘোষণা করছি যে, উল্লেখিত সকল তথ্যাদি সম্পূর্ণ সঠিক। যে কোন তথ্য ভুল প্রমাণিত হলে কর্তৃপক্ষের যে কোন সিদ্ধান্ত মেনে নিতে বাধ্য থাকবো। আমি আরও অঙ্গিকার করছি যে, বিদ্যালয়ের সকল নিয়ম-কানুন মেনে চলবো।</label>
        </div>
        <div class="flex justify-center">
            <button type="submit" id="submitBtn" onclick="return validateImageUpload()"
                class=" mt-2 px-4 py-2 bg-[<?= $main_top_bg ?>] text-white rounded hover:bg-[<?= $submenu_top_bg ?>] "
                disabled>
                <?= __d('setup', 'Submit') ?>
            </button>
            <?php echo $this->Form->end(); ?>
        </div>
        <div style="
        margin-top:15px;
        border:2px solid #2540a3;
        padding:12px 16px;
        border-radius:6px;
        background:#f8f9ff;
        font-size:14px;">
        <p style="margin:0 0 6px 0;">
            ফর্ম পূরণে কোনো অসুবিধা হলে নিচের নম্বরে যোগাযোগ করুন:
        </p>
    
        <strong style="color:#2540a3;">
            হেলপলাইন (টেকনিক্যাল): ০১৯৪১২০১২০৬,০১৯৪১২০১২০৭,০১৯৪১২০১২০৮
        </strong>
    </div>

    </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('declarationCheckbox').addEventListener('change', function() {
                document.getElementById('submitBtn').disabled = !this.checked;
            });
        });
    </script>

    <script>
        document.getElementById("stipendSelect").addEventListener("change", function() {
            const extraField = document.getElementById("stipendNumberField");
            if (this.value === "Yes") {
                extraField.classList.remove("hidden");
            } else {
                extraField.classList.add("hidden");
            }
        });

        $(document).ready(function() {
            function filterUpazilas(districtSelect, upazilaSelect) {
                var selectedId = $(districtSelect + ' option:selected').data('id'); // zila_id
                // Hide all except placeholder
                $(upazilaSelect + ' option').hide();
                $(upazilaSelect + ' option[value=""]').show();
                // Show only those matching selected zila_id
                if (selectedId !== undefined && selectedId !== null && selectedId !== '') {
                    $(upazilaSelect + ' option[data-zila="' + selectedId + '"]').show();
                }
                // reset selection
                $(upazilaSelect).val('');
            }

            // Present pair
            $('#zila_id').on('change', function() {
                filterUpazilas('#zila_id', '#upazila_id');
            });

            // Permanent pair
            $('#zila_id_2').on('change', function() {
                filterUpazilas('#zila_id_2', '#upazila_id_2');
            });

            // Other pair
            $('#zila_id_3').on('change', function() {
                filterUpazilas('#zila_id_3', '#upazila_id_3');
            });

            // Initial state (optional)
            filterUpazilas('#zila_id', '#upazila_id');
            filterUpazilas('#zila_id_2', '#upazila_id_2');
            // Other pair
            filterUpazilas('#zila_id_3', '#upazila_id_3');
        });
        // same address
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('sameAddress').addEventListener('change', function() {
                if (this.checked) {
                    // Copy all fields
                    document.getElementsByName('permanent_house')[0].value = document.getElementsByName('present_house')[0].value;
                    document.getElementsByName('permanent_village')[0].value = document.getElementsByName('present_village')[0].value;
                    document.getElementsByName('permanent_mouza')[0].value = document.getElementsByName('present_mouza')[0].value;
                    document.getElementsByName('permanent_post')[0].value = document.getElementsByName('present_post')[0].value;

                    document.getElementsByName('permanent_district')[0].value = document.getElementsByName('present_district')[0].value;
                    document.getElementsByName('permanent_upazila')[0].value = document.getElementsByName('present_upazila')[0].value;
                } else {
                    // Clear all fields
                    document.getElementsByName('permanent_house')[0].value = '';
                    document.getElementsByName('permanent_village')[0].value = '';
                    document.getElementsByName('permanent_mouza')[0].value = '';
                    document.getElementsByName('permanent_post')[0].value = '';

                    document.getElementsByName('permanent_district')[0].value = '';
                    document.getElementsByName('permanent_upazila')[0].value = '';
                }
            });
        });

        //show image
        document.getElementById('image-upload').addEventListener('change', function(event) {
            const reader = new FileReader();
            reader.onload = function() {
                document.getElementById('preview-image').src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        });

        // Get all required inputs and selects
        document.addEventListener('DOMContentLoaded', function() {
            const requiredFields = document.querySelectorAll('input[required], select[required], textarea[required]');

            requiredFields.forEach(function(field) {
                const label = field.closest('div')?.querySelector('label');
                if (label && !label.querySelector('.required-asterisk')) {
                    const asterisk = document.createElement('span');
                    asterisk.textContent = '*';
                    asterisk.className = 'text-red-500 required-asterisk';
                    label.prepend(asterisk);
                }
            });
        });
    </script>
    
    <script>
    function validateImageUpload() {
        var imageInput = document.getElementById('image-upload');
    
        if (!imageInput || imageInput.files.length === 0) {
            alert("Please upload an image before submitting.");
            return false; 
        }
    
        return true; 
    }
    </script>


<?php  } ?>