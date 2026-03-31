<div class="untree_co-section">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-7 text-center aos-init aos-animate" data-aos="fade-up" data-aos-delay="0">
                <h2 class="line-bottom text-center mb-4">Departments of BSMMC</h2>
                <nav class="navbar navbar-expand-lg navbar-light">
                    <div id="navbarNav">
                        <ul class="navbar-nav">
                            <?php foreach ($departments as $department) : ?>
                                <?php if ($department->parent_department === null) : ?>
                                    <li class="nav-item" data-target="<?= h($department->department_name) ?>">
                                        <a class="nav-link btn btn-primary btn-block" href="#"><?= h($department->department_name) ?></a>
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
                    <div id="<?= h($department->department_name) ?>" class="mt-3">
                        <div class="list-group">
                            <?php foreach ($department->children as $child) : ?>
                                <?php if ($child->children) : ?>
                                    <a href="#submenu<?= h($child->department_id) ?>" class="list-group-item dropdown_root" data-toggle="collapse"><?= h($child->department_name) ?></a>
                                    <div class="collapse" id="submenu<?= h($child->department_id) ?>">
                                        <?php foreach ($child->children as $subChild) : ?>
                                            <a href="#" class="list-group-item nested-list"><?= h($subChild->department_name) ?></a>
                                        <?php endforeach; ?>
                                    </div>
                                <?php else : ?>
                                    <a href="#" class="list-group-item"><?= h($child->department_name) ?></a>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="col-md-9">

                <ul class="list-unstyled mb-5 primary aos-init aos-animate" data-aos="fade-up" data-aos-delay="200">
                    <li><b>Department of Anatomy</b>
                        <ul class="list-unstyled ul-minus mb-5 primary">
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=132">Zobayer Mahmud Khan</a> - Associate
                                Professor
                                (CC)</li>
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=143">Dr. Mohammad Mofij Uddin</a> -
                                Curator</li>
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=139">Wahid Zaman</a> - Lecturer</li>
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=195">Dr. Md. Mostafizur Rahman</a> -
                                Lecturer</li>
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=209">Purna Chandra Das</a> - Lecturer
                            </li>
                        </ul>
                    </li>
                    <li><b>Department of Anesthesiology</b>
                        <ul class="list-unstyled ul-minus mb-5 primary">
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=166">Tapas Sarkar</a> - Assistant
                                Professor</li>
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=173">Ananta Biswas</a> - Assistant
                                Professor</li>
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=185">Shahadat Hossain</a> - Assistant
                                Professor</li>
                        </ul>
                    </li>
                    <li><b>Department of Biochemistry</b>
                        <ul class="list-unstyled ul-minus mb-5 primary">
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=157">Rezaul Quader</a> - Associate
                                Professor (CC)
                            </li>
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=133">Dr.Nasrin Akter</a> - Lecturer</li>
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=137">Adrita Abedin</a> - Lecturer</li>
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=178">Rabeya Khatun</a> - Lecturer</li>
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=187">MD MAHBUB UL ANWAR</a> - Biochemist
                            </li>
                        </ul>
                    </li>
                    <li><b>Department of Blood Transfusion Medicine</b>
                        <ul class="list-unstyled ul-minus mb-5 primary"></ul>
                    </li>
                    <li><b>Department of Burn and Plastic</b>
                        <ul class="list-unstyled ul-minus mb-5 primary">
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=200">Saneat Khan</a> - Assistant
                                Professor</li>
                        </ul>
                    </li>
                    <li><b>Department of Cardiology</b>
                        <ul class="list-unstyled ul-minus mb-5 primary">
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=145">Kartick Halder</a> - Assistant
                                Professor</li>
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=164">Muhammad Azmol Hossain</a> -
                                Assistant
                                Professor</li>
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=105">Azharul Islam Shaon</a> -
                                Biochemist</li>
                        </ul>
                    </li>
                    <li><b>Department of Community Medicine</b>
                        <ul class="list-unstyled ul-minus mb-5 primary"></ul>
                    </li>
                    <li><b>Department of Dentistry</b>
                        <ul class="list-unstyled ul-minus mb-5 primary"></ul>
                    </li>
                    <li><b>Department of Dermatology</b>
                        <ul class="list-unstyled ul-minus mb-5 primary">
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=135">Sumitendra Kumar Sarkar</a> -
                                Associate
                                Professor (CC)</li>
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=182">Md Kamal Mostofa</a> - Assistant
                                Professor</li>
                        </ul>
                    </li>
                    <li><b>Department of Forensic Medicine</b>
                        <ul class="list-unstyled ul-minus mb-5 primary">
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=151">KHAN ABU DAUD</a> - Lecturer</li>
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=153">Nuzhat Andalib</a> - Lecturer</li>
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=180">Mahadi Masud</a> - Lecturer</li>
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=196">Dr.Younus Ali</a> - Lecturer</li>
                        </ul>
                    </li>
                    <li><b>Department of Gastroenterology</b>
                        <ul class="list-unstyled ul-minus mb-5 primary">
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=190">A.T.M. Ataur Rahman</a> - Associate
                                Professor
                                (OSD)</li>
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=126">M. M. Shahin-Ul Islam</a> -
                                Associate Professor
                                (CC)</li>
                        </ul>
                    </li>
                    <li><b>Department of Hepatology</b>
                        <ul class="list-unstyled ul-minus mb-5 primary">
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=159">MD HUMAYAN MIAH</a> - Assistant
                                Professor (CC)
                            </li>
                        </ul>
                    </li>
                    <li><b>Department of Medicine</b>
                        <ul class="list-unstyled ul-minus mb-5 primary">
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=161">Faruk Ahammad</a> - Professor</li>
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=144">anisur rahman</a> - Associate
                                Professor (CC)
                            </li>
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=162">Ahmed Manadir Hossain</a> -
                                Associate Professor
                                (CC)</li>
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=51">M M Bodiuzzaman</a> - Assistant
                                Professor</li>
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=131">Mohammed Shahadat Hossain</a> -
                                Assistant
                                Professor</li>
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=134">M M Bodiuzzaman</a> - Assistant
                                Professor</li>
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=136">Mohammad Iqbal Hossain</a> -
                                Assistant
                                Professor</li>
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=152">Khan Arif</a> - Assistant Professor
                            </li>
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=174">Abubakar Siddique</a> - Assistant
                                Professor
                            </li>
                        </ul>
                    </li>
                    <li><b>Department of Microbiology</b>
                        <ul class="list-unstyled ul-minus mb-5 primary">
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=183">Imtiaz Ahmed</a> - Associate
                                Professor</li>
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=149">Khandaker Md. Tasnim Sajid</a> -
                                Assistant
                                Professor</li>
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=116">Anadia Ansari</a> - Curator</li>
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=150">Tarun Chaki</a> - Lecturer</li>
                        </ul>
                    </li>
                    <li><b>Department of Nephrology</b>
                        <ul class="list-unstyled ul-minus mb-5 primary">
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=155">Md Muqueet</a> - Associate
                                Professor</li>
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=160">Swapan Mondal</a> - Assistant
                                Professor</li>
                        </ul>
                    </li>
                    <li><b>Department of Neuro Medicine</b>
                        <ul class="list-unstyled ul-minus mb-5 primary">
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=147">Benzir Ahammad</a> - Assistant
                                Professor</li>
                        </ul>
                    </li>
                    <li><b>Department of Obstetrics and Gynaecology</b>
                        <ul class="list-unstyled ul-minus mb-5 primary">
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=130">Dilruba Zeba</a> - Professor</li>
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=202">Kaneez Fatema</a> - Associate
                                Professor (OSD)
                            </li>
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=211">Zakia Begum</a> - Assistant
                                Professor</li>
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=73">Samiya Alam</a> - Assistant
                                Professor (OSD)</li>
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=201">Samiya Alam</a> - Assistant
                                Professor (OSD)
                            </li>
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=165">Fahmida Zesmin</a> - Assistant
                                Professor (CC)
                            </li>
                        </ul>
                    </li>
                    <li><b>Department of Ophthalmology</b>
                        <ul class="list-unstyled ul-minus mb-5 primary">
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=148">Md Rahman</a> - Professor</li>
                        </ul>
                    </li>
                    <li><b>Department of Ortho Surgery</b>
                        <ul class="list-unstyled ul-minus mb-5 primary">
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=175">Gani Ahsan</a> - Professor</li>
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=156">Syed Asif Ul Alam</a> - Assistant
                                Professor
                            </li>
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=203">Md. Masudur Rahman</a> - Assistant
                                Professor
                            </li>
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=207">Mohammad Akhter</a> - Assistant
                                Professor</li>
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=125">Md Mizanur Rahman</a> - Assistant
                                Professor
                                (OSD)</li>
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=138">mizanur rahman</a> - Assistant
                                Professor (OSD)
                            </li>
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=168">Dr. Md. Muag Bin Jabal</a> -
                                Assistant
                                Professor (OSD)</li>
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=194">salim miah</a> - Assistant
                                Professor (OSD)</li>
                        </ul>
                    </li>
                    <li><b>Department of Otorhinolaryngology and Head Neck Surgery</b>
                        <ul class="list-unstyled ul-minus mb-5 primary">
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=172">Nripen Biswas</a> - Associate
                                Professor</li>
                        </ul>
                    </li>
                    <li><b>Department of Pathology</b>
                        <ul class="list-unstyled ul-minus mb-5 primary">
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=69">Partha Pratim Karmaker</a> -
                                Lecturer</li>
                        </ul>
                    </li>
                    <li><b>Department of Pediatric Surgery</b>
                        <ul class="list-unstyled ul-minus mb-5 primary">
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=74">Dr Amal Chandra Paul</a> - Associate
                                Professor
                            </li>
                        </ul>
                    </li>
                    <li><b>Department of Pediatrics</b>
                        <ul class="list-unstyled ul-minus mb-5 primary">
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=127">Abu Faisal Md Pervez</a> -
                                Assistant Professor
                            </li>
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=146">Mst. Naznin sarker</a> - Assistant
                                Professor
                            </li>
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=181">Monir Hossain</a> - Assistant
                                Professor</li>
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=210">Dr. Md. Mahmuder Rahman Firoz</a> -
                                Assistant
                                Professor (OSD)</li>
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=169">Khalid Syfullah</a> - Assistant
                                Professor (CC)
                            </li>
                        </ul>
                    </li>
                    <li><b>Department of Pharmacology</b>
                        <ul class="list-unstyled ul-minus mb-5 primary">
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=199">ATM Farid Uddin</a> - Professor
                            </li>
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=191">Dr. Suma Rani Pal</a> - Associate
                                Professor
                                (CC)</li>
                        </ul>
                    </li>
                    <li><b>Department of Physical Medicine</b>
                        <ul class="list-unstyled ul-minus mb-5 primary"></ul>
                    </li>
                    <li><b>Department of Physiology</b>
                        <ul class="list-unstyled ul-minus mb-5 primary">
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=176">Kamol Chandra Das</a> - Assistant
                                Professor
                                (CC)</li>
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=110">Md.Shahanur Rahman</a> - Lecturer
                            </li>
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=163">Farhana Sonia</a> - Lecturer</li>
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=177">Ishrat Jahan</a> - Lecturer</li>
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=189">Dr. Siddhartha Sankar Biswas</a> -
                                Lecturer
                            </li>
                        </ul>
                    </li>
                    <li><b>Department of Psychiatry</b>
                        <ul class="list-unstyled ul-minus mb-5 primary">
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=142">Farid Ahmed</a> - Assistant
                                Professor</li>
                        </ul>
                    </li>
                    <li><b>Department of Radiology and Imaging</b>
                        <ul class="list-unstyled ul-minus mb-5 primary">
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=158">Towrit Reza</a> - Assistant
                                Professor</li>
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=167">Salma Parvin</a> - Assistant
                                Professor</li>
                        </ul>
                    </li>
                    <li><b>Department of Radiotherapy</b>
                        <ul class="list-unstyled ul-minus mb-5 primary">
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=171">S.M.MUNAWAR MURSHED</a> - Assistant
                                Professor
                            </li>
                        </ul>
                    </li>
                    <li><b>Department of Surgery</b>
                        <ul class="list-unstyled ul-minus mb-5 primary">
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=154">ratan saha</a> - Professor</li>
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=186">Atikul Ahsan</a> - Assistant
                                Professor (CC)
                            </li>
                        </ul>
                    </li>
                    <li><b>Department of Urology</b>
                        <ul class="list-unstyled ul-minus mb-5 primary">
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=140">MOHAMMAD KHAN</a> - Assistant
                                Professor</li>
                            <li><a href="https://bsmmc.edu.bd/academic/teachers/?id=141">Muhammad Abul Khair</a> - Assistant
                                Professor
                            </li>
                        </ul>
                    </li>
                </ul>

            </div>
        </div>
    </div>
</div>
