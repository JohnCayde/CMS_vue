<template lang="">
    <div class="w-25 my-2 py-2 px-1 bg-secondary rounded">
        <h3 class="w-100">Page</h3>
        <ul class="w-100 list-group my-3">
            <li
                class="list-group-item d-flex justify-content-between p-1"
                v-for="page in AllPages"
                :key="page.page"
            >
                {{ page.name }}
                <button
                    type="button"
                    class="btn-close"
                    aria-label="Close"
                    :value="page.code"
                    @click="rmvPage"
                ></button>
            </li>
        </ul>
        <button
            class="btn btn-primary w-100"
            data-bs-toggle="modal"
            data-bs-target="#addPage"
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
        <div
            class="modal fade"
            id="addPage"
            tabindex="-1"
            aria-labelledby="addPage"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            Page Details
                        </h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="pageName" class="form-label"
                                >Page Name</label
                            >
                            <input
                                type="text"
                                class="form-control"
                                id="pageName"
                                placeholder="About"
                                v-model="name"
                            />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-primary"
                            data-bs-dismiss="modal"
                            @click="newPage"
                        >
                            Save changes
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";

export default {
    name: "PageList",
    data: () => {
        return {
            name: ""
        };
    },
    methods: {
        ...mapActions(["getPages", "addPage", "delPage"]),
        newPage() {
            const newPageNo = this.AllPages.length + 1;
            this.addPage({ page: newPageNo, name: this.name });
        },
        rmvPage(e) {
            this.delPage(e.target.value);
        }
    },
    computed: mapGetters(["AllPages"]),
    created(){
        this.getPages()
    }
};
</script>

<style lang=""></style>
