<template>
    <div v-if="comment" class="uk-margin-xlarge-bottom">
        <div class="star-rating">
            <div v-for="(star, index) in stars" :key="index" class="star-container">
                <button @click="setRate(index+1)" class="uk-icon-button star-button">
                    <svg
                        :id="index+1"
                        class="star-svg"
                        :style="[
                        { fill: ratingColor[index] },
                        { width: styleStarWidth },
                        { height: styleStarHeight }
                    ]"
                    >
                        <polygon :points="getStarPoints" style="fill-rule:nonzero;"/>
                    </svg>
                </button>
            </div>
            <div class="uk-text-bold uk-margin-small-left uk-margin-small" :style="styleRateColor">{{ ratingFixed }}</div>
        </div>
        <textarea class="uk-textarea uk-width uk-height-small" :placeholder="commentText" id="comment" v-model="content" ></textarea>
        <button v-if="isUpdate" @click="clearForm" :uk-toggle="'target: .review'+userId" class="uk-button uk-margin-small-left uk-button-default uk-margin-small-top uk-float-right "> {{cancelText}} </button>
        <button @click="submitReview(setComment)" class="uk-button uk-button-primary uk-margin-small-top uk-float-right "> {{sendText}} </button>
    </div>
</template>

<script>
    import Axios from 'axios'
    import {mapActions} from "vuex";
    export default {
        name: "stars-rating",
        props: {
            courseId:{
                type:String,
                required:true,
            },
            isUpdate:{
                type:Boolean,
                default:false
            },
            moduleName:{
                type:String,
                required:true,
            },
            sendText:{
                type:String,
                default:"Gönder",
            },
            commentText:{
                type:String,
                default:"Yorum Yaz...",
            },
            userId:{
                type:String,
                required: true,
            },
            isRating:{
                type:Boolean,
                default:false,
            },
            rating: {
                type: Number,
                default: 5,
            },
            review:{
                type:String,
                default:"",
            },
            apiStatus:{
                type:String,
                default:'create',
            },
            starStyle: {
                type: Object
            },
            isIndicatorActive: {
                type: Boolean,
                default: true
            },
            styleStarWidth:{
                type: Number,
                default: 18
            },
            styleStarHeight:{
                type: Number,
                default: 18
            },
            styleEmptyStarColor:{
                type:String,
                default:"#C1C1C1",
            },
            styleFullStarColor:{
                type:String,
                default:"#F4C150",
            },
            styleRateColor:{
                color:{
                    type:String,
                    default:'#212529',
                }
            },
            cancelText:{
                type:String,
                default:"Vazgeç"
            }
        },
        data: function () {
            return {
                stars: [],
                emptyStar: 0,
                fullStar: 1,
                totalStars: 5,
                rate:this.rating,
                ratingColor:[this.styleFullStarColor,this.styleFullStarColor,this.styleFullStarColor,this.styleFullStarColor,this.styleFullStarColor,],
                comment:true,
                content:this.review,
            };
        },
        directives: {},
        computed: {
            getStarPoints: function () {
                let centerX = this.styleStarWidth / 2;
                let centerY = this.styleStarWidth / 2;

                let innerCircleArms = 5; // a 5 arms star

                let innerRadius = this.styleStarWidth / innerCircleArms;
                let innerOuterRadiusRatio = 2.5; // Unique value - determines fatness/sharpness of star
                let outerRadius = innerRadius * innerOuterRadiusRatio;

                return this.calcStarPoints(
                    centerX,
                    centerY,
                    innerCircleArms,
                    innerRadius,
                    outerRadius
                );
            },
            ratingFixed:function () {
                return this.rate.toFixed(1);
            },
            module(){
                switch (this.moduleName) {
                    case 'prepareLessons': return 'pl';
                    case 'prepareExams': return 'pe';
                    case 'live':return 'live';
                    default: return 'ge';
                }
            }
        },
        methods: {
            ...mapActions([
                'loadCourseReviews',
            ]),
            setComment( can ){
                this.comment=can;
            },
            submitReview( setMethod ){
                Axios.post('/api/comment/'+this.module+'/'+this.apiStatus, {
                    content:this.content,
                    point:this.ratingFixed,
                    course_id:this.courseId,
                    user_id:this.userId
                })
                .then(function (response) {
                    if(response.data.error){
                        UIkit.notification({message: response.data.errorMessage, status: 'danger'});
                    }else{
                        UIkit.notification({message: response.data.message, status: 'success'});
                    }
                    setMethod(response.data.error);
                    document.location.reload();
                }).catch((error)=>{
                    if(error.response) {
                        if(error.response.errorMessage){
                            UIkit.notification({message: error.response.data.errorMessage, status: 'danger'});
                        }else{
                            UIkit.notification({message: error.response.data.message, status: 'danger'});
                        }
                    }});
            },
            setRate(rating){
                this.rate=rating;
                for (var i=1;i<=5;i++){
                    if (i>(rating)){
                        this.ratingColor[i-1] = this.styleEmptyStarColor
                    }else{
                        this.ratingColor[i-1]= this.styleFullStarColor
                    }
                }
            },
            calcStarPoints(
                centerX,
                centerY,
                innerCircleArms,
                innerRadius,
                outerRadius
            ) {
                let angle = Math.PI / innerCircleArms;
                let angleOffsetToCenterStar = 60;

                let totalArms = innerCircleArms * 2;
                let points = "";
                for (let i = 0; i < totalArms; i++) {
                    let isEvenIndex = i % 2 == 0;
                    let r = isEvenIndex ? outerRadius : innerRadius;
                    let currX = centerX + Math.cos(i * angle + angleOffsetToCenterStar) * r;
                    let currY = centerY + Math.sin(i * angle + angleOffsetToCenterStar) * r;
                    points += currX + "," + currY + " ";
                }
                return points;
            },
            initStars() {
                for (let i = 0; i < this.totalStars; i++) {
                    this.stars.push({
                        raw: this.emptyStar,
                        percent: this.emptyStar + "%"
                    });
                }
            },
            setStars() {
                let fullStarsCounter = Math.floor(this.rate);
                for (let i = 0; i < this.stars.length; i++) {
                    if (fullStarsCounter !== 0) {
                        this.stars[i].raw = this.fullStar;
                        this.stars[i].percent = this.calcStarFullness(this.stars[i]);
                        fullStarsCounter--;
                    } else {
                        let surplus = Math.round((this.rate % 1) * 10) / 10; // Support just one decimal
                        let roundedOneDecimalPoint = Math.round(surplus * 10) / 10;
                        this.stars[i].raw = roundedOneDecimalPoint;
                        return (this.stars[i].percent = this.calcStarFullness(this.stars[i]));
                    }
                }
            },
            getFullFillColor(starData) {
                return starData.raw !== this.emptyStar
                    ? this.styleFullStarColor
                    : this.styleEmptyStarColor;
            },
            calcStarFullness(starData) {
                let starFullnessPercent = starData.raw * 100 + "%";
                return starFullnessPercent;
            },
            setNestedConfigStyles(objToFlatten) {
                if (typeof objToFlatten === "object") {
                    for (let i in objToFlatten) {
                        let newKey =
                            "style" + i.charAt(0).toUpperCase() + i.substring(1, i.length);
                        this[newKey] = objToFlatten[i];
                    }
                }
            },
            clearForm:function () {
                this.setRate(this.rating);
                this.content=this.review;
            }
        },
        mounted() {
            this.setNestedConfigStyles(this.starStyle);
            this.initStars();
            this.setStars();
        },
        created() {
            this.setRate(this.rating);
        }

    };
</script>
<style scoped lang="scss">
    .star-rating {
        display: flex;
        align-items: center;
        .star-container {
            display: flex;
            .star-svg {
                max-height: 20px;
                max-width:25px;
            }
        }
        .indicator {
        }
        .star-container:not(:last-child) {
            margin-right: 5px;
        }
    }
    .star-button {
        background-color: white;
    }
    .star-button:focus {
        background-color: white;
    }
</style>
