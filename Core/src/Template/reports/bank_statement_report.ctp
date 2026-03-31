<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
    /* Your CSS styles here */
    body {
        font-family: Arial, sans-serif;
    }

    .header {
        text-align: center;
        font-weight: bold;
        font-size: 16px;
    }

    .header span {
        display: block;
    }

    .contact-info {
        text-align: center;
        font-size: 14px;
        margin-top: 5px;
    }

    .memo {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 14px;
        border-top: 2px solid black;
    }

    .info p {
        font-size: 15px;
        margin: 5px 0;
    }

    .info strong {
        width: 70px;
        display: inline-block;
    }

    .info span {
        margin-left: 10px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    table,
    th,
    td {
        border: 1px solid black;
    }

    th,
    td {
        padding: 8px;
        text-align: center;
    }

    th {
        background-color: #f4f4f4;
    }

    .signature {
        width: 30%;
        text-align: center;
        margin-top: 80px;
        float: right;
    }

    .signature p {
        margin: 0;
        font-size: 15px;
    }

    .signature strong {
        font-size: 16px;
    }

    .header {
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
        width: 100%;
        text-align: center;
    }

    .header-image {
        position: absolute;
        left: 0;
        width: 90px;
        height: auto;
        margin: 70px;
    }

    .header-text {
        padding-left: 60px;
        font-size: 16px;
    }
    @media print {
    .noprint {
        display: none !important;
    }


}
    </style>
</head>

<body>
    <?php
    
    unset($request_data['bank']);
    // unset($request_data['sarok']);

$filtered_data = array_filter($request_data, function($value) {
    return !empty($value);
});
?>

<div class="noprint" style="margin-bottom: 3px; float: left;">
    <?php 
    $output = [];
    foreach ($filtered_data as $key => $value) {
        // If report_type is not "govt", append "Bank"
        if ($key === 'report_type' && strtolower($value) !== 'govt') {
            $value = ucfirst(strtolower($value)) . " Bank";
        } else {
            $value = ucfirst(strtolower($value)); // Only capitalize first letter
        }
        
        $output[] = "<strong>" . ucfirst(str_replace('_', ' ', $key)) . ":</strong> " . htmlspecialchars($value);
    }
    echo implode(" | ", $output); 
    ?>
</div>



    
    <div class="noprint" style="margin-bottom: 3px;float: right;">
        <a class="btn btn-warning account" href="javascript:window.print();">প্রিন্ট করুন</a>
    </div>

    <div class="header">
        <img src="https://dgghs.edu.bd/uploads/logo1.png?1733722333" alt="Image" class="header-image">
        <div class="header-text">
            গণপ্রজাতন্ত্রী বাংলাদেশ সরকার<br>
            প্রধান শিক্ষকের কার্যালয়<br>
            দিনাজপুর সরকারি বালিকা উচ্চ বিদ্যালয়<br>
            www.dgghs.edu.bd, EIIN: 120718<br>
            Board Code: 7514, Center Code: 728<br>
        </div>
    </div>

    <div class="contact-info">
        <span>টেলিফোন: ০৫৩১-৬৫০২০, মোবাইল: ০১৩০৯-১২০৭১৮, ই-মেইল: dinajpurgirlsschool@gmail.com</span>
    </div>

    <div class="memo">
        <span class="left">স্মারক নং: দিসবাউবি/<?= htmlspecialchars($request_data['sarok']); ?></span>
        <span class="right currentDate">তারিখ: </span>
    </div>
    <?php if ($transactions[0]['report_type'] == 'sonali') { ?>
    <div class="info">
        <p><strong>বরাবর,</strong></br><span style="margin-left: 80px;">ব্যবস্থাপক</span><br><span
                style="margin-left: 80px;">সোনালী ব্যাংক
                পিএলসি</span><br><span style="margin-left: 80px;">কর্পোরেট শাখা, মুন্সিপাড়া, দিনাজপুর।</span></p>
        <div><strong>বিষয়:</strong> টাকা স্থানান্তর প্রসঙ্গে।</div></br>
        <div style="text-align: justify;font-size: 15px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;যথাযথ সম্মান
            প্রদর্শনপূর্বক নিম্নস্বাক্ষরকারী বিনীতভাবে জানাচ্ছেন যে, সোনালী ব্যাংক পিএলসি, কর্পোরেট শাখা, মুন্সিপাড়া,
            দিনাজপুর এর হিসাব ডিজিজিএইচএস স্টুডেন্ট অল ফিস ফান্ড, হিসাব নং ১৮০৯৩০১০২৬৭৮৩ একাউন্ট থেকে নিম্নলিখিত একাউন্ট
            নম্বরগুলোতে উল্লিখিত পরিমাণ টাকা স্থানান্তরের জন্য অনুরোধ করা হলো।</div>
    </div>

    <?php  } else if ($transactions[0]['report_type'] == 'rupali') {
    ?>
    <div class="info">
        <p><strong>বরাবর,</strong></br><span style="margin-left: 80px;">ব্যবস্থাপক</span><br><span
                style="margin-left: 80px;">সোনালী ব্যাংক
                পিএলসি</span><br><span style="margin-left: 80px;">কর্পোরেট শাখা, মুন্সিপাড়া, দিনাজপুর।</span></p>
        <div><strong>বিষয়:</strong> টাকা স্থানান্তর প্রসঙ্গে।</div></br>
        <div style="text-align: justify;font-size: 15px;">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;যথাযথ সম্মান প্রদর্শনপূর্বক নিম্নস্বাক্ষরকারী বিনীতভাবে
            জানাচ্ছেন যে,
            সোনালী ব্যাংক পিএলসি, কর্পোরেট শাখা, মুন্সিপাড়া, দিনাজপুর এর হিসাব ডিজিজিএইচএস স্টুডেন্ট অল ফিস ফান্ড,
            হিসাব নং ১৮০৯৩০১০২৬৭৮৩ একাউন্ট থেকে রূপালী ব্যাংক পিএলসি রাউটিং নং (১৮৫২৮১৩০২), মহিলা শাখা, বাসুনিয়াপট্টি, দিনাজপুর-এর
            নিম্নলিখিত একাউন্ট নম্বরগুলোতে উল্লিখিত পরিমাণ টাকা স্থানান্তরের জন্য অনুরোধ করা হলো।
            <br><br>

        </div>
    </div>
    <?php  } else { ?>

    <div class="info">
        <p><strong>বরাবর,</strong></br><span style="margin-left: 80px;">ব্যবস্থাপক</span><br><span
                style="margin-left: 80px;">সোনালী ব্যাংক
                পিএলসি</span><br><span style="margin-left: 80px;">কর্পোরেট শাখা, মুন্সিপাড়া, দিনাজপুর।</span></p>
        <div><strong>বিষয়:</strong> টাকা স্থানান্তর প্রসঙ্গে।</div></br>
        <div style="text-align: justify;font-size: 15px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;যথাযথ সম্মান
            প্রদর্শনপূর্বক নিম্নস্বাক্ষরকারী বিনীতভাবে জানাচ্ছেন যে, সোনালী ব্যাংক পিএলসি, কর্পোরেট শাখা, মুন্সিপাড়া,
            দিনাজপুর এর হিসাব ডিজিজিএইচএস স্টুডেন্ট অল ফিস ফান্ড, হিসাব নং ১৮০৯৩০১০২৬৭৮৩ একাউন্ট থেকে ট্রেজারি চালানের
            মাধ্যমে সরকারি কোষাগারে উল্লিখিত পরিমাণ টাকা স্থানান্তর করার জন্য অনুরোধ করা হলো।</div>
    </div>


    <?php  }
    ?>

    <div>
        <?php
        $totals = [];
        $grandTotal = 0;

        // Function to convert numbers to Bengali digits
        function convertToBengaliNumber($number)
        {
            return str_replace(
                range(0, 9),
                ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'],
                $number
            );
        }

        foreach ($transactions as $transaction) {
            $purposeId = $transaction['purpose_id'];
        
            if (!isset($totals[$purposeId])) {
                $totals[$purposeId] = [
                    'purpose_id'     => $transaction['purpose_id'],
                    'report_title'   => $transaction['report_title'],
                    'account_number' => $transaction['account_no'],
                    'total_amount'   => 0
                ];
            }
        
            $totals[$purposeId]['total_amount'] += $transaction['amnt'];
            $grandTotal += $transaction['amnt'];
        }
        ?>

        <table border="1">
            <thead>
                <tr>
                    <th>ক্রমিক নং</th>
                    <th>তহবিলের নাম</th>
                    <th>হিসাব নম্বর</th>
                    <th>টাকার পরিমান</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $serial = 1;
                foreach ($totals as $purposeId => $data) { ?>
                <tr>
                    <td><?= convertToBengaliNumber($serial++); ?></td>
                    <td><?= htmlspecialchars($data['report_title']); ?></td>
                    <td><?= htmlspecialchars($data['account_number']); ?></td>
                    <td><?= convertToBengaliNumber(number_format($data['total_amount'], 2)); ?></td>
                </tr>
                <?php } ?>
                <tr>
                    <td colspan="3" style="text-align:right; font-weight:bold;">মোট</td>
                    <td style="font-weight:bold;"><?= convertToBengaliNumber(number_format($grandTotal, 2)); ?></td>
                </tr>
            </tbody>
        </table>
    </div>


    <div class="signature">
        <p>নাজমা ইয়াসমীন<br>
            <strong>প্রধান শিক্ষক(ভারপ্রাপ্ত)</strong><br>
            সরকারি বালিকা উচ্চ বিদ্যালয়,<br>দিনাজপুর
        </p>
    </div>

    <script>
    // Function to get the current date in DD/MM/YYYY format in Bengali
    function formatDateInBengali() {
        const today = new Date();
        const day = String(today.getDate()).padStart(2, '0');
        const month = String(today.getMonth() + 1).padStart(2, '0');
        const year = today.getFullYear();

        // Bengali numbers mapping
        const bengaliNumbers = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];

        function toBengaliNumber(number) {
            return number.split('').map(digit => bengaliNumbers[parseInt(digit)]).join('');
        }

        const bengaliDay = toBengaliNumber(day);
        const bengaliMonth = toBengaliNumber(month);
        const bengaliYear = toBengaliNumber(year.toString());

        return `${bengaliDay}/${bengaliMonth}/${bengaliYear}`;
    }

    // Set the formatted date in Bengali for all elements with the class "currentDate"
    const dateElements = document.querySelectorAll('.currentDate');
    dateElements.forEach(element => {
        element.textContent = "তারিখ: " + formatDateInBengali();
    });
    </script>

</body>

</html>