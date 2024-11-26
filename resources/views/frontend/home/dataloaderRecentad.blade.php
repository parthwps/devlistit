<style>
     /* Skeleton loading effect farhan */
     .skeltonFlex{
        display: flex;
        flex-direction: column;
        /* width: 100%; */

     }
.skeleton {
    background: #e0e0e0;
    border-radius: 4px;
    position: relative;
    overflow-x: auto;
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
    height: 230px;
    width: 100%;
    /* margin-bottom: 20px; */
}

.skeleton-title {
    /* height: 23px; */
    width: 80%;
    /* margin-bottom: 10px; */
}

.skeleton-content {
    /* height: 18px; */
    width: 90%;
    /* margin-bottom: 10px; */
}

.skeleton-content.small {
    /* height: 18px; */
    width: 70%;
    /* margin-bottom: 10px; */
}   
</style>
    
    
    <!-- Skeleton Loader for Image -->
     <div class="skeltonFlex">
    <div class="card-img radius-0  skeleton skeleton-img"></div>
    <!-- Skeleton Loader for Title -->
    <h4 class="skeleton skeleton-title "></h4>
    <!-- Skeleton Loader for Content -->
    <p class="skeleton skeleton-content "></p>
    <p class="skeleton skeleton-content small "></p>
</div>