<template>
    <div v-if="canReview" class="uk-margin-xlarge-bottom">
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
        <textarea class="uk-textarea uk-width uk-height-small" placeholder="Yorum Yaz..." id="comment" > </textarea>
        <button @click="submitReview" class="uk-button uk-button-primary uk-margin-small-top uk-float-right "> Gönder </button>
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
            canReview:{
              type:Boolean,
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
                // Binded Nested Props registered as data/computed and not props
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
        },
        methods: {
            ...mapActions([
                'loadCourseReviews',
            ]),
            submitReview(){
                Axios.post('/api/comment/create', {
                    content: document.getElementById('comment').value,
                    point:this.ratingFixed,
                    course_id:this.courseId,
                    user_id:this.userId
                })
                .then(function (response) {
                    if(response.data.error){
                        UIkit.notification({message: response.data.message, status: 'danger'});

                    }else{
                        UIkit.notification({message: response.data.message, status: 'success'});
                    }
                });
                this.$store.dispatch('loadCourseReviews',this.courseId);
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
            }
        },
        mounted() {
            this.setNestedConfigStyles(this.starStyle);
            this.initStars();
            this.setStars();
        },

    };
</script>
<style scoped lang="scss">
    .star-rating {
        display: flex;
        align-items: center;
        .star-container {
            display: flex;
            .star-svg {
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
