<template>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header text-center">
                        <h3>Phone Numbers</h3>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <select  v-model="code" id ="code" name = "code" class="select form-control " aria-describedby="basic-addon2" @change="listCustomers()">
                                    <option value="">Select Country</option>
                                    <option value="237">Cameroon</option>
                                    <option value="251">Ethiopia</option>
                                    <option value="212">Morocco</option>
                                    <option value="258">Mozambique</option>
                                    <option value="256">Uganda</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <select id ="is_valid" v-model="status"  name = "is_valid" class="select form-control " aria-describedby="basic-addon2" @change="listCustomers()">
                                    <option value="">Select Status</option>
                                    <option value=1>Valid</option>
                                    <option value=0>Invalid</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered text-center">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Country</th>
                                    <th>Code</th>
                                    <th>Phone</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody v-model="customers" v-if="customers && customers.data.length > 0">
                                <tr v-for="(customer,index) in customers.data" :key="index">
                                    <td>{{ customer.name }}</td>
                                    <td>{{ customer.country }}</td>
                                    <td>{{ customer.code }}</td>
                                    <td>{{ customer.phone }}</td>
                                    <td> {{ customer.status }}</td>
                                </tr>
                                </tbody>
                                <tbody v-else>
                                <tr>
                                    <td align="center" colspan="3">No record found.</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <pagination :data="customers" @pagination-change-page="listCustomers"></pagination>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import pagination from 'laravel-vue-pagination'
export default {
    name:"customers",
    components:{
        pagination
    },
    data(){
        return {
            customers: {},
            status: "",
            code: "",
        }
    },
    created() {

        this.listCustomers();

    },
    mounted(){
        console.log('Component mounted.')
    },
    methods:{
        listCustomers(page =1) {
            let url = "/api/customers?";
            if (this.status) {
                url = url + "is_valid="+this.status+ '&';
            }
            if (this.code) {
                url = url + "code="+this.code + '&';
            }
            url = url+`page=${page}`;
            axios.get(url).then(response => {
                this.customers = response.data;
                console.log("cust");
                console.log(this.customers);
            }).catch(({ response })=>{
                console.error(response)
            })
        }
    }
}
</script>

<style scoped>
.pagination{
    margin-bottom: 0;
}
</style>
