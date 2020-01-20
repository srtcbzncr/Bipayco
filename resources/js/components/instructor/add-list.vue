<template>
    <div>
        <div class="">
            <input class="uk-padding-small uk-margin-small-top uk-input uk-width-4-5@m" type="text" :id="id" :placeholder="addDefaultText">
            <button class="uk-button uk-button-success uk-margin-small-top uk-width-1-6@m" @click="addItem"><i class="fas fa-plus"></i> <span class="uk-hidden@m">{{addText}}</span></button>
        </div>
        <div class="uk-margin-medium">
            <ul>
                <li v-for="(item,index) in items">
                    <div class="uk-flex flex-wrap">
                        <p>{{item}}</p>
                        <a class="uk-button-icon uk-margin-left" @click="removeItem(index)"><i class="fas fa-trash-alt text-danger icon-small"> </i></a>
                    </div>
                </li>
            </ul>
        </div>
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
            }
        },
        data(){
            return{
                items:[]
            }
        },
        methods:{
            addItem:function () {
                this.items.push(document.getElementById(this.id).value);
            },
            removeItem:function ( index) {
                this.items.splice(index,1);
            }
        }
    }
</script>

<style scoped>

</style>
