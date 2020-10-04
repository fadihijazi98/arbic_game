<template>

    <div class="row" dir="rtl">
        <div class="col-10">
            <table class="col-10 table table-hover table-borderless table-vcenter font-size-sm text-right" dir="rtl">
                <thead class="thead-light">
                <tr class="">
                    <th class="d-sm-table-cell font-w700 "><i class="fa fa-globe-arrow-up"></i>#</th>
                    <th class=" d-sm-table-cell font-w700">السؤال</th>
                    <th class=" d-sm-table-cell font-w700">الاجابة</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="item in rowData" class="">
                    <td>{{ item.col_id }}</td>
                    <td>{{ item.title }}</td>
                    <td>
                        <button type="button" class="btn btn-success" @click="statusTrue(item)" :disabled="item.disabled">
                        <span ><i class="fa fa-times text-warning mr-1"></i>
                            إجابة صحيحة
                        </span>
                        </button>
                        <button type="button" class="btn btn-danger" @click="disabled(item)" :disabled="item.disabled">
                            <span ><i class="fa fa-check text-success mr-1"></i>إجابة خاطئة </span>
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>

        </div>
        <div class="col-2 text-center">
            <h2>
                 <span id="timer" style="padding: 40px;border: 1px solid red; border-radius: 50%;
font-size: 20px; font-weight: bold">
                     {{ timer }}
                 </span>
            </h2>
        </div>
    </div>
</template>

<script>
export default {
name: "Admin.vue",
    mounted() {
        this.fetch();
    },
    data:function () {
        return{
            timer: 0,
            score: 0,
            questionsView: 0,
            title: '',
            rowData:[],
            id : 0
        }
    },
    directives: {
        myMountedDirective (el, { value }) {
            console.log(value + 'jjj')

        }
    },
    methods:{
        fetch(){
            setInterval(() => this.fetchQuestion(), 1000)
        },
        countDown(){
            if(this.timer > 1) {
                setTimeout(() => {
                    this.timer -= 1
                    this.countDown()
                }, 1000)
            }
        },
        fetchQuestion(){
            axios.get('/fetch')
                .then( (response) => {
                    if(this.title != response.data.question_title) {
                        this.timer=0;
                        this.rowData.push({
                            id: response.data.question_id,title: response.data.question_title, timer: response.data.duration,
                            status: response.data.status, disabled: false , col_id: this.id ++
                        });
                        this.timer = response.data.duration;
                        this.countDown()
                        this.id +=1;
                    }
                     this.title = response.data.question_title;
                });
        },
        statusTrue(item){
            item.status = true;

            axios.patch('/question/updateStatus/' + item.id, {
                item,})
                .then(function (response) {
                }), error => {
                if (error.code == 500) {
                    console.log(error.data)
                }
            }
        },
        disabled(item){
            item.disabled= true;
        },
        addScore(item){
            this.score+=1;
            this.disabled(item)
        },
    }

}
</script>

<style scoped>

</style>
