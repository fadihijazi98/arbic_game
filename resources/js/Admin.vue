<template>

    <div class="row w-100" dir="rtl">
        <div class="container">
            <div class="col-12 text-center" v-if="this.rowData.length>0">
                <h2>
                 <span id="timer" class="text-danger"
                       style="display:inline-flex;justify-content:center;align-items:center;width: 50px;height:50px;border: 1px solid; border-radius: 50%">
                     {{ timer }}
                 </span>
                </h2>
            </div>
            <div class="col-12 mt-4">
                <table
                    class="col-10 table table-hover table-borderless table-vcenter font-size-sm text-right text-center"
                    dir="rtl">
                    <thead class="thead-light">
                    <tr class="">
                        <th class="d-sm-table-cell font-w700 "><i class="fa fa-globe-arrow-up"></i>رقم السؤال</th>
                        <th class=" d-sm-table-cell font-w700">عنوان السؤال</th>
                        <th class=" d-sm-table-cell font-w700">الاجابة</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="item in rowData" class="">
                        <td>{{ item.id }}</td>
                        <td>{{ item.title }}</td>
                        <td>
                            <button type="button" class="btn btn-success" @click="statusTrue(item)"
                                    :disabled="item.disabled">
                        <span><i class="fa fa-times text-warning mr-1"></i>
                            إجابة صحيحة
                        </span>
                            </button>
                            <button type="button" class="btn btn-danger" @click="statusFalse(item)"
                                    :disabled="item.disabled">
                                <span><i class="fa fa-check text-success mr-1"></i>إجابة خاطئة </span>
                            </button>
                        </td>
                    </tr>
                    <tr class="bg-info text-white p-4">
                        <td>

                        </td>
                        <td>

                        </td>
                        <td>
                            <h4>
                                {{ this.scoreAsText }}
                            </h4>
                        </td>
                    </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Admin.vue",
    mounted() {
        this.fetch();
    },
    props: {
        session_id: {
            type: Number,
            required: true
        }
    },
    data: function () {
        return {
            timer: 0,
            score: 0,
            questionsView: 0,
            title: '',
            rowData: [],
            scoreAsText: '',
            id: 0,
        }
    },
    directives: {
        myMountedDirective(el, {value}) {
            console.log(value + 'jjj')

        }
    },
    methods: {
        fetch() {
            setInterval(() => this.fetchQuestion(), 1000)
        },
        countDown() {
            if (this.timer > 0) {
                setTimeout(() => {
                    this.timer -= 1
                    this.countDown()
                }, 1000)
            }
        },
        fetchQuestion() {
            axios.get('/fetch?session_id=' + this.session_id)
                .then((response) => {
                    if (this.title != response.data.question_title && response.data.question_title != undefined) {
                        this.timer = 0;
                        this.rowData.push({
                            id: response.data.question_id,
                            title: response.data.question_title,
                            timer: response.data.duration,
                            status: response.data.status,
                            disabled: false,
                            col_id: this.id++
                        });
                        this.timer = response.data.duration;
                        this.countDown();
                        this.id += 1;
                    }
                    this.scoreAsText = response.data.scoreAsText;
                    this.title = response.data.question_title;
                });
        },
        statusTrue(item) {
            this.timer = 1;
            item.status = true;
            axios.patch('/question/updateStatus/' + item.id, {
                item,
            })
                .then(function (response) {
                }), error => {
                if (error.code == 500) {
                    console.log(error.data)
                }
            }
        },
        statusFalse(item) {
            this.timer = 1;
            item.status = false;
            axios.patch('/question/updateStatus/' + item.id, {
                item,
            })
                .then(function (response) {
                }), error => {
                if (error.code == 500) {
                    console.log(error.data)
                }
            }
        },
        addScore(item) {
            this.score += 1;
            this.disabled(item)
        },
    }

}
</script>

<style scoped>

</style>
