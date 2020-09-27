<template>
    <div class="container" dir="rtl">
        <div v-if="questionsLength != questionsView" class="row justify-content-start align-content-center" style="height: 100vh">
            <div v-for="(question, i) in questions" class="col-md-3 col-sm-4 text-center">
                <button :id="'btn'+i" class="text-center p-4 mt-4 btn btn-outline-dark" data-toggle="modal" data-target="#question" @click="selectedQuestion(question, i)">
                    <h3>
                        السؤال رقم
                        {{i+1}}
                    </h3>
                </button>
            </div>
        </div>

        <div class="modal fade" id="question" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="incQuestionsView()">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h2 class="text-right text-danger">
                            {{ questionSelected.title }}
                        </h2>
                        <p class="text-right" style="font-size: 22px">
                            {{ questionSelected.content }}
                        </p>
                        <div class="text-danger text-center">
                            <h2>
                                <span id="timer" style="padding: 8px;border: 1px solid; border-radius: 50%">
                                    {{ timer }}
                                </span>
                            </h2>
                        </div>
                    </div>
                    <div class="modal-footer" style="justify-content:start!important;">
                        <button type="button" class="btn btn-success font-weight-bold" data-dismiss="modal" @click="addScore()">اجابة صحيحه</button>
                        <button type="button" class="btn btn-danger font-weight-bold" data-dismiss="modal" @click="incQuestionsView()">اجابة خاطئة</button>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="questionsView === questionsLength" class="row justify-content-center align-content-center text-center" style="height: 100vh">
            <h1>
                انتهت الاسالة : والتحصيل
                <br>
                النهائي هو
                <span class="text-danger">
                     {{ score }}
                 من
                {{ questionsLength }}
                </span>
            </h1>
        </div>
    </div>
</template>

<script>
export default {
    name: "Game",
    props: {
        questions: {
            type: Array,
            required: true
        }
    },
    data: function () {
        return {
            timer: 0,
            score: 0,
            questionsView: 0,
            questionsLength: this.questions.length,
            questionSelected: ""
        };
    },
    methods: {
        selectedQuestion(question, i) {
            this.questionSelected = question;
            this.timer = this.questionSelected.duration;
            document.getElementById("btn"+i).classList.add("d-none");
        },
        addScore() {
            this.score += 1;
            this.incQuestionsView();
        },
        incQuestionsView() {
            this.questionsView += 1;
        },
        timeDown() {
            alert(this.timer);
        }
    }

}
</script>

<style scoped>

</style>
