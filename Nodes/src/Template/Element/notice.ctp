<?php
      $notice = $this->requestAction('nodes/notice'); //pr($notice); 
      $count = $this->requestAction('nodes/notice');
      ?>
<ul>
      <?php
      foreach ($notice as $nott) :
            if (is_array($nott)) {
                  foreach ($nott as $not) :
                        //pr($not);
                        /**For Month Display**/
                        $month = substr($not['Node']['created'], 5, 2);
                        $bangla_month = array('জানুয়ারী', 'ফেব্রুয়ারী', 'মার্চ', 'এপ্রিল', 'মে', 'জুন', 'জুলাই', 'অগাস্ট', 'সেপ্টেম্বর', 'অক্টোবর', 'নভেম্বর', 'ডিসেম্বর');
                        foreach ($bangla_month as $x => $value) {
                              if ($month == $x + 1) {
                                    $month_res = $value;
                              }
                        }

                        //echo $month_res;

                        /**For Year Display**/
                        $year = substr($not['Node']['created'], 0, 4);
                        $bangla_year = array(
                              '2000' => '২০০০', '2001' => '২০০১', '2002' => '২০০২', '2003' => '২০০৩', '2004' => '২০০৪', '2005' => '২০০৫', '2006' => '২০০৬',
                              '2007' => '২০০৭', '2008' => '২০০৮', '2009' => '২০০৯', '2010' => '২০১০', '2011' => '২০১১', '2012' => '২০১২', '2013' => '২০১৩',
                              '2014' => '২০১৪', '2015' => '২০১৫', '2016' => '২০১৬', '2017' => '২০১৭', '2018' => '২০১৮', '2019' => '২০১৯', '2020' => '২০২০',
                              '2021' => '২০২১', '2022' => '২০২২', '2023' => '২০২৩', '2024' => '২০২৪', '2025' => '২০২৫', '2026' => '২০২৬', '2027' => '২০২৭',
                              '2028' => '২০২৮', '2029' => '২০২৯', '2030' => '২০৩০', '2031' => '২০৩১', '2032' => '২০৩২', '2033' => '২০৩৩', '2034' => '২০৩৪',
                              '2035' => '২০৩৫', '2036' => '২০৩৬', '2037' => '২০৩৭', '2038' => '২০৩৮', '2039' => '২০৩৯', '2040' => '২০৪০', '2041' => '২০৪১',
                              '2042' => '২০৪২', '2043' => '২০৪৩', '2044' => '২০৪৪', '2045' => '২০৪৫', '2046' => '২০৪৬', '2047' => '২০৪৭', '2048' => '২০৪৮',
                              '2049' => '২০৪৯', '2050' => '২০৫০'
                        );
                        foreach ($bangla_year as $x => $value) {
                              if ($year == $x) {
                                    $year_res = $value;
                              }
                        }
                        //echo $year_res;
                        /**For Day Display**/
                        $date = substr($not['Node']['created'], 8, 2);
                        $bangla_date = array('০১', '০২', '০৩', '০৪', '০৫', '০৬', '০৭', '০৮', '০৯', '১০', '১১', '১২', '১৩', '১৪', '১৫', '১৬', '১৭', '১৮', '১৯', '২০', '২১', '২২', '২৩', '২৪', '২৫', '২৬', '২৭', '২৮', '২৯', '৩০', '৩১');

                        foreach ($bangla_date as $x => $value) {
                              if ($date == $x + 1) {
                                    $date_res = $value;
                              }
                        }
                        //echo $date_res;
      ?>
                        <li><a href="<?php echo $this->request->base ?><?php echo $not['Node']['path']; ?>"><span class="acc_title"><span><?php echo $date_res;
                                                                                                                                          echo $month_res; ?></span><?php echo $year_res; ?></span><?php echo $not['Node']['title']; ?></a></li>
      <?php
                  endforeach;
            }
      endforeach; ?>
</ul>

<?php if ($count['count'] > 5) { ?>
      <div class="lwrLink">
            <a href="<?php echo $this->request->base ?>/notice">সবগুলো জানতে &raquo;</a>
      </div>
<?php } ?>