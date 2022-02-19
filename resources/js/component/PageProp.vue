<template>
    <div class="w-75 m-2 bg-secondary rounded d-flex flex-wrap justify-content-center">
        <div
            v-for="(PageComp, index) in AllPageComps"
            :key="index"
            class="card m-2"
        >
            <div class="card-body relative card-min-size">
                <h5 class="card-title">
                    <u>{{ PageComp.name }}</u>
                </h5>
                <ul class="w-100 list-group my-3 compList">
                    <li
                        class="list-group-item d-flex justify-content-between"
                        v-for="(comp, index) in PageComp.components"
                        :key="index"
                    >
                        {{ comp.name }}
                        <div>
                            <button class="btn p-1" :data-page="PageComp.code" :data-comp="comp.code" @click="showProp">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="16"
                                    height="16"
                                    fill="currentColor"
                                    class="bi bi-three-dots-vertical"
                                    viewBox="0 0 16 16"
                                >
                                    <path
                                        d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"
                                    />
                                </svg>
                            </button>
                            <button
                                class="btn p-0"
                                :data-page="PageComp.code"
                                :data-comp="comp.code"
                                @click="rmvComp"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="16"
                                    height="16"
                                    fill="currentColor"
                                    class="bi bi-x-lg"
                                    viewBox="0 0 16 16"
                                >
                                    <path
                                        d="M1.293 1.293a1 1 0 0 1 1.414 0L8 6.586l5.293-5.293a1 1 0 1 1 1.414 1.414L9.414 8l5.293 5.293a1 1 0 0 1-1.414 1.414L8 9.414l-5.293 5.293a1 1 0 0 1-1.414-1.414L6.586 8 1.293 2.707a1 1 0 0 1 0-1.414z"
                                    />
                                </svg>
                            </button>
                        </div>
                    </li>
                </ul>
                <div class="addComp d-flex">
                    <button
                        class="btn btn-primary w-100"
                        data-bs-toggle="modal"
                        data-bs-target="#CompModal"
                        :value="PageComp.code"
                        @click="showAllComp"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="16"
                            height="16"
                            fill="currentColor"
                            class="bi bi-plus-lg mx-auto"
                            viewBox="0 0 16 16"
                        >
                            <path
                                d="M8 0a1 1 0 0 1 1 1v6h6a1 1 0 1 1 0 2H9v6a1 1 0 1 1-2 0V9H1a1 1 0 0 1 0-2h6V1a1 1 0 0 1 1-1z"
                            />
                        </svg>
                    </button>
                    <!-- <button class="btn btn-primary w-50">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="16"
                            height="16"
                            fill="currentColor"
                            class="bi bi-arrow-left-right mx-auto"
                            viewBox="0 0 16 16"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M1 11.5a.5.5 0 0 0 .5.5h11.793l-3.147 3.146a.5.5 0 0 0 .708.708l4-4a.5.5 0 0 0 0-.708l-4-4a.5.5 0 0 0-.708.708L13.293 11H1.5a.5.5 0 0 0-.5.5zm14-7a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 4H14.5a.5.5 0 0 1 .5.5z"
                            />
                        </svg>
                    </button> -->
                </div>
            </div>
        </div>
        <div
            class="modal fade"
            id="CompModal"
            tabindex="-1"
            aria-labelledby="CompModelLabal"
            aria-hidden="true"
            data-bs-backdrop="static"
        >
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="CompModalLabel">
                            Component List
                        </h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                            @click="hideAllComp"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <select
                            class="form-select"
                            aria-label="Default select example"
                            v-model="compCode"
                        >
                            <option value="">Open this select menu</option>
                            <option
                                v-for="(comp, index) in AllComps"
                                :key="index"
                                :value="comp.code"
                                >{{ comp.name }}</option
                            >
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal"
                            @click="hideAllComp"
                        >
                            Close
                        </button>
                        <button
                            type="button"
                            class="btn btn-primary"
                            @click="newComp"
                            data-bs-dismiss="modal"
                        >
                            Save changes
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div
            class="modal fade"
            id="PropModal"
            tabindex="-1"
            aria-labelledby="PropModalLabel"
            aria-hidden="true"
            data-bs-backdrop="static"
        >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="PropModalLabel">
                            Component Setting
                        </h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                            @click="hideProp"
                        ></button>
                    </div>
                    <NavBarProp v-if="compName == 'navbar'" :pageCode="compPage" :compCode="compCd" :props="compProp" v-on:close="hideProp"/>
                    <CardListProp v-else-if="compName == 'cards'" :pageCode="compPage" :compCode="compCd" :props="compProp" v-on:close="hideProp"/>
                    <CarouselProp v-else-if="compName == 'carousel'" :pageCode="compPage" :compCode="compCd" :props="compProp" v-on:close="hideProp"/>
                    <EnquiryProp v-else-if="compName == 'enquiry'" :pageCode="compPage" :compCode="compCd" :props="compProp" v-on:close="hideProp"/>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import { Modal } from 'bootstrap';
import NavBarProp from './NavBarProp.vue'
import CardListProp from './CardListProp.vue'
import CarouselProp from './CarouselProp.vue'
import EnquiryProp from './EnquiryProp.vue'

export default {
    name: "PageProp",
    components:{
        NavBarProp,
        CardListProp,
        CarouselProp,
        EnquiryProp
    },
    data: () => {
        return {
            pageCode: "",
            compCode: "",
            compName: "",
            compProp: {},
            compPage: "",
            compCd: "",
            propModal: null
        };
    },
    methods: {
        ...mapActions(["getComps", "addComp", "delComp"]),
        showAllComp(e) {
            this.pageCode = e.currentTarget.value;
        },
        hideAllComp() {
            this.pageCode = "";
            this.compCode = "";
        },
        newComp(e) {
            if (this.pageCode == "") {
                alert("Unable to detect which page you add on to. Operation terminate");
                return;
            }

            if (this.compCode == "") {
                alert("Unable to detect which component you choose. Operation terminate");
                return;
            }

            const comp = this.AllComps.find(comp => comp.code == this.compCode);
            this.addComp({ pageCode: this.pageCode, compCode:this.compCode});

            this.pageCode == "";
            this.compCode == "";
        },
        rmvComp(e) {
            this.delComp({
                pageCode: e.currentTarget.dataset.page,
                compCode: e.currentTarget.dataset.comp
            });
        },
        showProp(e){
            const pgCode = e.currentTarget.dataset.page
            const cpCode = e.currentTarget.dataset.comp

            const pgidx = this.AllPageComps.findIndex(page=>page.code == pgCode)
            const cpidx = this.AllPageComps[pgidx].components.findIndex(comp=>comp.code == cpCode)

            this.compName = this.AllPageComps[pgidx].components[cpidx].name
            this.compProp = this.AllPageComps[pgidx].components[cpidx].props
            this.compPage = pgCode
            this.compCd = cpCode

            this.propModal.show()
        },
        hideProp(e){
            this.propModal.hide()
            this.compName = ""
            this.compProp = {}
            this.compPage = ""
            this.compCd = ""
        }
    },
    computed: mapGetters(["AllPageComps", "AllComps"]),
    mounted() {
        const propModalEl = document.getElementById('PropModal')
        if (propModalEl) {
            console.log("found")
        } else {
            console.log("No found")
        }
        this.propModal = new Modal(propModalEl, {backdrop:"static"});
    },
    created(){
        this.getComps()
    }
};
</script>

<style>
.card-min-size {
    min-height: 300px;
    min-width: 220px;
}

.addComp {
    width: 80%;
    position: absolute;
    bottom: 1rem;
    left: 1rem;
}

.compList{
    max-height: 180px;
    overflow: auto;
}
</style>
