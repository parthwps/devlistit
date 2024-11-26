<style>
    .browseCars{
        font-size: 30px; color: #0d0c1b !important;
    }
    .nextBtn, .prevBtn{
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 3px;
    }
    .nextBtn:hover, .prevBtn:hover{
        background: #F8F8F8;
    }
    .car-container {
        overflow-x: scroll;
        white-space: nowrap;
        display: flex;
        justify-content: center;
        align-items: center
        transition: all 0.3s ease;
        padding: 0px 30px;

    }
    .car-container:hover > a {
        color: #0d0c1b !important;
    }
    .car-box {
        background: #F8F8F8;
        border: 4px solid #F8F8F8;
        height: 190px;
        min-width: 212px;
        margin-right: 10px; /* Gap between boxes */
    }
    @media (max-width: 1290px){
        .car-container {
        overflow-x: scroll;
        white-space: nowrap;
        display: flex;
        justify-content: start;
        transition: all 0.3s ease;
        padding: 0px 30px;
    }
    }
    @media (max-width: 525px){
        .car-container {
        overflow-x: scroll;
        white-space: nowrap;
        display: flex;
        justify-content: start;
        transition: all 0.3s ease;
        padding-left:  10px;
    }
        .browseCars{
            font-size: 20px; 
        }  
    }
    @media (max-width: 375px){
        .browseCars{
            font-size: 20px; 
        }  
    }

    </style>