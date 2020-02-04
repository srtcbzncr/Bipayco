<template>
    <div class="lessonSettings" hidden>
        <div class="uk-margin-top">
            <h4>{{editLessonText}}</h4>
        </div>
        <hr>
        <div>
            <div class="uk-form-label">{{lessonNameText}}</div>
            <input class="uk-input" type="text" :value="selectedLessonInfo.name" id="inputName" required>
        </div>
        <div>
            <div class="uk-form-label">{{sourcesText}}</div>
            <ul>
                <li v-for="source in selectedLessonInfo.sources">
                    <div class="uk-flex align-items-center uk-margin">
                        <div class="uk-width-5-6 uk-flex uk-flex-wrap">
                            <p class="uk-margin-remove" style="text-overflow: ellipsis; overflow:hidden;">{{source.title}}</p>
                        </div>
                        <div class="uk-width-1-6">
                            <a class="uk-button-icon uk-margin-left uk-margin-remove-bottom uk-margin-remove-top uk-margin-remove-right"><i class="fas fa-trash-alt text-danger icon-small"> </i></a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <div class=" uk-margin-small uk-flex justify-content-start align-items-center">
            <label>
                <input v-if="selectedLessonInfo.isPreview=='0'" class="uk-checkbox" type="checkbox">
                <input v-else checked class="uk-checkbox" type="checkbox">
                <span class="checkmark uk-text-small">{{isPreviewText}}</span>
            </label>
        </div>
        <div class="uk-width-1-1 uk-grid">
            <div class="uk-width-1-2@m">
                <button class="uk-button uk-button-default uk-width uk-margin-small-top uk-margin-small-left uk-margin-small-right" uk-toggle="target: .lessonSettings"><i class="fas fa-times uk-margin-small-right"></i>{{cancelText}}</button>
            </div>
            <div class="uk-width-1-2@m">
                <button class="uk-button uk-button-success uk-width uk-margin-small-top uk-margin-small-left uk-margin-small-right" uk-toggle="target: .lessonSettings"><i class="fas fa-save uk-margin-small-right"></i>{{saveText}} </button>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapActions, mapState} from "vuex";

    export default {
        name: "lesson-settings",
        props:{
            editLessonText:{
                type:String,
                default:'Ders Düzenle'
            },
            lessonNameText:{
                type:String,
                default:'Ders Adı'
            },
            sourcesText:{
                type:String,
                default:'Kaynaklar'
            },
            isPreviewText:{
                type:String,
                default:'Önizleme'
            },
            saveText:{
                type:String,
                default:'Kaydet'
            },
            cancelText:{
                type:String,
                default:'Vazgeç'
            },
        },
        computed:{
            ...mapState([
                'selectedLessonInfo',
            ]),
        },
        methods:{
            ...mapActions([
                'loadSelectedLessonInfo',
            ]),
        },
    }
</script>

<style scoped>

</style>
