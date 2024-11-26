<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Skeleton loading effect */
        .skeleton-grid {
            background: #e0e0e0;
            border-radius: 4px;
            position: relative;
            overflow: hidden;
        }

        .skeleton-grid::before {
            content: '';
            position: absolute;
            top: 0;
            left: -150px;
            height: 100%;
            width: 150px;
            background: linear-gradient(90deg, rgba(255, 255, 255, 0), rgba(255, 255, 255, 0.2), rgba(255, 255, 255, 0));
            animation: loading 1.2s infinite;
        }

        @keyframes loading {
            0% {
                left: -150px;
            }
            50% {
                left: 100%;
            }
            100% {
                left: 100%;
            }
        }

        /* Adjust skeleton for image, title, and content */
        .skeleton-grid-img {
            height: 200px;
            width: 100%;
            margin-bottom: 20px;
        }

        .skeleton-grid-title {
            height: 20px;
            width: 80%;
            margin-bottom: 10px;
        }

        .skeleton-grid-content {
            height: 15px;
            width: 90%;
            margin-bottom: 10px;
        }

        .skeleton-grid-content.small {
            height: 15px;
            width: 70%;
            margin-bottom: 10px;
        }   
    </style>
    <title>Skeleton Loader Cards</title>
</head>
<body>
    <div class="container main-skeleton-container">
        <div class="row">
            <!-- Card 1 -->
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow">
                    <div class="card-img radius-0 mb-25 skeleton-grid skeleton-grid-img"></div>
                    <h4 class="skeleton-grid skeleton-grid-title m-2"></h4>
                    <p class="skeleton-grid skeleton-grid-content m-2"></p>
                    <p class="skeleton-grid skeleton-grid-content small m-2"></p>
                    <p class="skeleton-grid skeleton-grid-content small m-2"></p>
                </div>
            </div>
            <!-- Card 2 -->
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow">
                    <div class="card-img radius-0 mb-25 skeleton-grid skeleton-grid-img"></div>
                    <h4 class="skeleton-grid skeleton-grid-title m-2"></h4>
                    <p class="skeleton-grid skeleton-grid-content m-2"></p>
                    <p class="skeleton-grid skeleton-grid-content small m-2"></p>
                    <p class="skeleton-grid skeleton-grid-content small m-2"></p>
                </div>
            </div>
            <!-- Card 3 -->
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow">
                    <div class="card-img radius-0 mb-25 skeleton-grid skeleton-grid-img"></div>
                    <h4 class="skeleton-grid skeleton-grid-title m-2"></h4>
                    <p class="skeleton-grid skeleton-grid-content m-2"></p>
                    <p class="skeleton-grid skeleton-grid-content small m-2"></p>
                    <p class="skeleton-grid skeleton-grid-content small m-2"></p>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
<?php /**PATH /home/u673667181/domains/listit.im/public_html/resources/views/frontend/car/dataloader-grid.blade.php ENDPATH**/ ?>