<template>
    <div class="container d-flex justify-content-center align-items-center" dir="rtl">
        <!--Object.keys(this.questions).length==0-->
        <div v-if="elementVisible===true">
            <vue-ellipse-progress :progress="progress" animation="loop" dash="10 10"/>
        </div>
        <div v-else-if="Object.keys(this.questions).length==0">
            <h3>
                انتهت الاسالة،
                <br>
                <span class="text-danger">
                    {{ scoreMessage }}
                </span>
            </h3>
        </div>
        <div>
            <div class="row justify-content-start align-content-center" style="height: 100vh">
                <div v-for="(question, i) in questions" :key="question.id" class="col-md-3 col-sm-4 text-center m-4">
                    <button :id="'btn'+i" class="text-center p-4 mt-4 btn btn-outline-dark" data-toggle="modal"
                            data-target="#question" @click="selectedQuestion(question, i)">
                        <h3>
                            السؤال :
                            {{ question.title }}
                        </h3>
                    </button>
                </div>
            </div>

            <div class="modal fade" id="question" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="incQuestionsView()">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <h2 class="text-right text-danger">
                                {{ this.questionSelected.title }}
                            </h2>
                            <p class="text-right" style="font-size: 22px">
                                {{ this.questionSelected.content }}
                            </p>
                            <div style="padding: 4px; margin: 2px" v-if="questionSelected.image_path!='storage/'">
                                <img :src="`/`+questionSelected.image_path" style="max-width: 100%" />
                            </div>
                            <div class="text-danger text-center">
                                <h2>
                                <span id="timer"
                                      style="display:inline-flex;justify-content:center;align-items:center;width: 50px;height:50px;border: 1px solid; border-radius: 50%">
                                    {{ timer }}
                                </span>
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import VueEllipseProgress from 'vue-ellipse-progress';

export default {
    name: "Game",
    props: {
        session_id: {
            type: Number,
            required: true
        }
    },
    data: function () {
        return {
            timer: 0,
            questions: {},
            questionSelected: "",
            elementVisible: true,
            scoreMessage: "",
            interval:  "",
        };
    },
    watch: {
        timer: function () {
            this.$emit("selected-timer", this.timer);
        },
    },
    components: [VueEllipseProgress],
    methods: {
        fetch() {
            setInterval(() => this.fetchQuestions(), 1000)
        },
        selectedQuestion(question, i) {
            axios.post('/selected/save', [question, this.session_id])
                .then(function (response) {
                    // this.myTickers.unshift({title:this.toSave.title, is_published: this.toSave.is_published=0,
                    //     id: response.data.id, created_at:response.data.created_at});
                    // this.toSave={}
                })
                .catch(function (response) {
                    console.log("error in send of request")
                });

            this.questionSelected = question;

            this.timer = this.questionSelected.duration;

            this.timeDown();

            document.getElementById("btn" + i).classList.add("d-none");
        },
        fetchQuestions() {
            axios.get("/fetch/" + this.session_id).then((response) => {
                this.questions = {};
                if (Object.keys(response.data).length == 0) {
                    this.getScore();
                }
                this.questions = response.data;
            });
        },
        timeDown() {
            if (this.timer > 0) {
                setTimeout(() => {
                    this.timer -= 1
                    this.timeDown()
                }, 1000)
            }
        },
        getScore() {
            axios.get("/score/" + this.session_id).then((response) => {
                this.scoreMessage = response.data;
            })
        },
        incQuestionsView() {
            this.timer = 0 ;
        },
    },
    mounted() {
        this.interval = setInterval(() => this.fetchQuestions(), 1100);
    },
    created() {
        setTimeout(() => this.elementVisible = false, 1200)
    }

}
</script>

<style scoped>

</style>
