<style>
    /* Modern Navbar */
    #navbar {
        background: #1f2937;
        /* modern dark gray */
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 18px;
        flex-wrap: wrap;
        color: #fff;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
    }

    /* Logo + Mobile Title */
    .mobile-title {
        font-size: 18px;
        font-weight: 600;
        letter-spacing: .5px;
    }

    /* Toggle Button */
    #navbarCollapse {
        display: none;
        background: #3b82f6;
        border: none;
        color: white;
        padding: 8px 12px;
        border-radius: 6px;
        font-size: 18px;
        cursor: pointer;
        transition: 0.3s ease;
    }

    #navbar ul {
        list-style: none;
        display: flex;
        gap: 15px;
        margin: 0;
        padding: 0;
    }

    #navbar ul li a {
        color: #e5e7eb;
        text-decoration: none;
        padding: 10px 14px;
        border-radius: 6px;
        font-size: 15px;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: 0.3s;
    }

    #navbar ul li.active a,
    #navbar ul li a:hover {
        background: #3b82f6;
        color: #fff;
    }

    /* MOBILE VIEW */
    @media (max-width: 767px) {
        #navbar {
            flex-direction: column;
            align-items: flex-start;
        }

        #navbarCollapse {
            display: block;
            margin-right: 10px;
        }

        #navbar ul {
            flex-direction: column;
            width: 100%;
            margin-top: 10px;
            display: none;
        }

        #navbar ul.show {
            display: flex;
        }

        #navbar ul li {
            width: 100%;
        }

        #navbar ul li a {
            width: 100%;
            padding: 12px 14px;
        }
    }

    /* CONTENT SECTIONS */
    .content-section {
        display: none;
        padding: 20px;
        animation: fadeIn 0.4s ease;
    }

    .content-section.active {
        display: block;
    }

    /* Fade animation */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(8px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>


<!-- NAVBAR -->
<nav id="navbar">
    <div class="d-flex align-items-center">
        <button id="navbarCollapse"><i class="fa fa-bars"></i></button>
        <span class="mobile-title px-2">Student Dashboard</span>
    </div>

    <ul>
        <li class="active"><a href="#" data-content="dashboard-content"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="#" data-content="attendance-content"><i class="fa fa-sticky-note"></i> Attendance</a></li>
        <li><a href="#" data-content="result-content"><i class="fa fa-certificate"></i> Result</a></li>
        <li><a href="#" data-content="accounts-content"><i class="fa fa-money"></i> Accounts</a></li>
        <li><a href="#" data-content="personal-info-content"><i class="fa fa-user-circle"></i> Personal Info</a></li>
    </ul>
</nav>

<!-- CONTENT -->
<div id="content">
    <div class="content-section active" id="dashboard-content">
        <?= $this->element('user_dashboard'); ?>
    </div>
    <div class="content-section" id="attendance-content">
        <?= $this->element('user_attendance'); ?>
    </div>
    <div class="content-section" id="result-content">
        <?= $this->element('user_result'); ?>
    </div>
    <div class="content-section" id="accounts-content">
        <?= $this->element('user_accounts'); ?>
    </div>
    <div class="content-section" id="personal-info-content">
        <?= $this->element('user_informations'); ?>
    </div>
</div>

<script>
(function ($) {

    // Mobile menu toggle
    $('#navbarCollapse').on('click', function () {
        $('#navbar ul').toggleClass('show');
    });

    // Switch tabs
    $('#navbar ul li a').on('click', function (e) {
        e.preventDefault();

        var contentId = $(this).data('content');

        // Active menu
        $('#navbar ul li').removeClass('active');
        $(this).parent().addClass('active');

        // Content switch (NO fadeIn)
        $('.content-section').removeClass('active').hide();
        $('#' + contentId).show().addClass('active');

        // Close mobile menu
        if (window.innerWidth < 768) {
            $('#navbar ul').removeClass('show');
        }
    });

})(jQuery);
</script>