<template>
    <div>
        <div class="">
            <input class="uk-padding-small uk-margin-small-top uk-input uk-width-4-5@m" type="text" :id="id" :placeholder="addDefaultText">
            <button class="uk-button uk-button-success uk-margin-small-top uk-width-1-6@m" @click="add"><i class="fas fa-plus"></i> <span class="uk-hidden@m">{{addText}}</span></button>
        </div>
        <form class="uk-margin-medium">
            <ul>
                <li v-for="(item,index) in items">
                    <div class="uk-flex">
                        <p>{{item}}</p>
                        <input :name="inputName" hidden disabled :value="item">
                        <a class="uk-button-icon uk-margin-left" @click="removeItem(index)"><i class="fas fa-trash-alt text-danger icon-small"> </i></a>
                    </div>
                </li>
            </ul>
        </form>
    </div>
</template>

<script>
    export default {
        name: "add-achievements",
        props:{
            addDefaultText:{
                type:String,
                default:"",
            },
            addText:{
                type:String,
                default:"Ekle",
            },
            id:{
                type:String,
                required:true,
            },
            field:{
                type:String,
                required: true,
            },
            courseId:{
                type:String,
                required:true,
            }
        },
        data(){
            return{
                items:[]
            }
        },
        computed:{
            inputName(){
                return this.id+"[]";
            }
        },
        methods:{
            addItem:function (item) {
                this.items.push(item);
            },
            add:function(){
              this.addItem(document.getElementById(this.id).value);
            },
            removeItem:function ( index) {
                this.items.splice(index,1);
            }
        },
        created() {
            axios.get('/api/instructor/course/'+this.courseId+'/goals')
                .then(response=>response.data.data)
                .then(response=>{
                    switch (this.field) {
                    case "achievements":{
                        for (var i=0; i<response.achievements.length; i++){
                            this.addInstructor(response.achievements[i]);
                        }
                        break;
                    }
                    case "requirements":{
                        for (var i=0; i<response.requirements.length; i++){
                            this.addInstructor(response.requirements[i]);
                        }
                        break;
                    }
                    case "tags":{
                        for (var i=0; i<response.tags.length; i++){
                            this.addInstructor(response.tags[i]);
                        }
                        break;
                    }
                    default:break;
                    }

                })

        }
    }
</script>

<style scoped>

</style>
