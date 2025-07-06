<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="Press and media coverage featuring Dr. Shiv Coaching">
    <meta name="keywords" content="Dr. Shiv Coaching, media coverage, press, news">
    <meta name="author" content="Dr. Shiv Coaching">
    <title>Media Coverage – Dr. Shiv Coaching</title>
    <?php include 'includes/links.php'; ?>
    <style>
        /* --- Media gallery tweaks (feel free to move to your CSS file) --- */
        .media-gallery {
            padding: 60px 0;
        }

        .media-card {
            border: 0;
            transition: transform .25s, box-shadow .25s;
        }

        .media-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, .1);
        }

        .media-card img {
            width: 100%;
            object-fit: cover;
            border-radius: .5rem;
        }

        .media-card-title {
            margin: 0.75rem 0;
            font-size: 1.125rem;
            font-weight: 600;
            text-align: center;
        }

        .media-link {
            text-decoration: none;
            color: inherit;
        }

        /* --- Bottom section --- */
        .press-cta {
            background: #f7f7f9;
            padding: 80px 0;
        }

        .press-cta p {
            max-width: 720px;
            margin: 0 auto 1.5rem;
        }
    </style>
</head>

<body>
    <!-- Preloader -->
    <div class="preloader">
        <div class="loading-container">
            <div class="loading"></div>
            <div id="loading-icon"><img src="images/loader.svg" alt="Dr. Shiv Coaching loader icon" /></div>
        </div>
    </div>

    <!-- Header -->
    <?php include 'includes/header.php'; ?>

    <!-- Page Header -->
    <header class="page-header bg-section parallaxie">
        <div class="page-header-box">
            <div class="container-fluid">
                <h1 class="wow fadeInUp">Media&nbsp;<span>Coverage</span></h1>
                <nav class="wow fadeInUp" data-wow-delay="0.25s">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">media&nbsp;coverage</li>
                    </ol>
                </nav>
            </div>
        </div>
    </header>

    <!-- Media Coverage Gallery -->
    <section class="media-gallery">
        <div class="container">
            <div class="row g-4">

                <!-- Media Item -->
                <div class="col-lg-3 col-md-6">
                    <a href="https://example.com/article-1" class="media-link" target="_blank" rel="noopener">
                        <article class="media-card">
                            <img src="images/mid-day.jpeg" alt="Coverage from Mid Day" loading="lazy">
                            <h2 class="media-card-title">Mid Day</h2>
                        </article>
                    </a>
                </div>

                <!-- Media Item -->
                <div class="col-lg-3 col-md-6">
                    <a href="https://example.com/article-2" class="media-link" target="_blank" rel="noopener">
                        <article class="media-card">
                            <img src="images/uni-india.jpeg" alt="Coverage from UNI India" loading="lazy">
                            <h2 class="media-card-title">UNI India</h2>
                        </article>
                    </a>
                </div>

                <!-- Media Item -->
                <div class="col-lg-3 col-md-6">
                    <a href="https://example.com/article-3" class="media-link" target="_blank" rel="noopener">
                        <article class="media-card">
                            <img src="images/apn-live.jpeg" alt="Coverage from APN Live" loading="lazy">
                            <h2 class="media-card-title">APN Live</h2>
                        </article>
                    </a>
                </div>

                <!-- Duplicate the above block for more outlets -->
            </div>
        </div>
    </section>

    <!-- Press Call‑to‑Action -->
    <section class="press-cta text-center">
        <div class="container">
            <h2 class="wow fadeInUp my-4">Recognized by Top Media Houses</h2>
            <p class="wow fadeInUp" data-wow-delay="0.15s">
                Dr. Shiv Coaching has been featured in several reputed media houses for its transformative approach to student success. Explore our latest press appearances above and stay tuned for more milestones ahead.
            </p>
            <a href="contact.php" class="btn-default wow fadeInUp" data-wow-delay="0.25s" target="_blank" rel="noopener">get in touch with us</a>

    </section>

    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>
    <?php include 'includes/scripts.php'; ?>
</body>

</html>