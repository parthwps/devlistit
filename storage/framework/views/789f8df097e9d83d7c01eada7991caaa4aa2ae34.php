<style>
     /* Skeleton loading effect */
.skeleton {
    background: #e0e0e0;
    border-radius: 4px;
    position: relative;
    overflow: hidden;
}

.skeleton::before {
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
.skeleton-img {
    height: 200px;
    width: 100%;
    margin-bottom: 20px;
}

.skeleton-title {
    height: 20px;
    width: 80%;
    margin-bottom: 10px;
}

.skeleton-content {
    height: 15px;
    width: 90%;
    margin-bottom: 10px;
}

.skeleton-content.small {
    height: 15px;
    width: 70%;
    margin-bottom: 10px;
}   
</style>
    
    
    <!-- Skeleton Loader for Image -->
    <div class="card-img radius-0 mb-25 skeleton skeleton-img"></div>
    <!-- Skeleton Loader for Title -->
    <h4 class="skeleton skeleton-title m-2"></h4>
    <!-- Skeleton Loader for Content -->
    <p class="skeleton skeleton-content m-2"></p>
    <p class="skeleton skeleton-content small m-2"></p>
    <p class="skeleton skeleton-content small m-2"></p>
<?php /**PATH /home/u673667181/domains/listit.im/public_html/resources/views/frontend/home/dataloader.blade.php ENDPATH**/ ?>