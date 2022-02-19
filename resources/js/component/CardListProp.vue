<template lang="">
    <div class="modal-body">
        <div class="d-flex flex-column">
            <div :class="containerClass">
                <div
                    v-for="(content, idx) in UserProps[contextIndex].value"
                    :class="cardClass"
                >
                    <div>{{ content }}</div>
                </div>
            </div>
            <table class="table table-bordered w-auto">
                <tr>
                    <th class="no-column-width">No</th>
                    <th class="w-25">Attribute</th>
                    <th class="w-50">Value</th>
                </tr>
                <tr v-for="(prp, idx) in CardListProps" class="row-height">
                    <!-- No -->
                    <td>{{ idx + 1 }}</td>
                    <!-- prop name -->
                    <td>{{ prp.name }}</td>
                    <!-- prop value -->
                    <td v-if="prp.name == 'Content'">
                        <ul class="list-group">
                            <li
                                v-for="(content, index) in UserProps[idx].value"
                                :key="index"
                                class="list-group-item d-flex justify-content-between"
                            >
                                <div class="input-group input-group-sm">
                                    <span
                                        class="input-group-text"
                                        id="inputGroup-sizing-sm"
                                        >{{ index + 1 }}</span
                                    >
                                    <input
                                        type="text"
                                        class="form-control"
                                        aria-label="Sizing example input"
                                        aria-describedby="inputGroup-sizing-sm"
                                        v-model="UserProps[idx].value[index]"
                                    />
                                </div>
                            </li>
                        </ul>
                    </td>
                    <td v-else-if="prp.name == 'Count'">
                        <select
                            class="form-select"
                            v-model="UserProps[idx].value"
                            @change="changePageCount"
                        >
                            <option
                                v-for="(opt, index) in prp.value"
                                :key="index"
                                :value="opt"
                                >{{ opt }}</option
                            >
                        </select>
                    </td>
                    <td v-else-if="prp.type == 'Boolean'" class="text-center">
                        <input
                            type="checkbox"
                            class="form-check-input"
                            v-model="UserProps[idx].value"
                        />
                    </td>
                    <td v-else-if="prp.type == 'Array'">
                        <select
                            class="form-select"
                            v-model="UserProps[idx].value"
                        >
                            <option
                                v-for="(opt, index) in prp.value"
                                :key="index"
                                :value="opt"
                                >{{ opt }}</option
                            >
                        </select>
                    </td>
                </tr>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" @click="submit">
                Save changes
            </button>
        </div>
    </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";

export default {
    name: "CardList",
    props: {
        pageCode: String,
        compCode: String,
        props: Object
    },
    data: () => {
        return {
            UserProps: [],
            contextIndex: 0,
            containerClass: "",
            cardClass: ""
        };
    },
    methods: {
        ...mapActions(["updateProps"]),
        changePageCount() {
            const countIndex = this.UserProps.findIndex(
                prop => prop.name == "Count"
            );
            const contextIndex = this.UserProps.findIndex(
                prop => prop.name == "Content"
            );

            const count = Number.parseInt(this.UserProps[countIndex].value);
            const originalCount = this.UserProps[countIndex].value.length;
            let newContent = [];
            if (originalCount < count) {
                for (let i = 0; i < count; i++) {
                    if (originalCount > i) {
                        newContent.push(this.UserProps[contextIndex].value[i]);
                    } else {
                        newContent.push("");
                    }
                }
            } else {
                for (let i = 0; i < count; i++) {
                    newContent.push(this.UserProps[contextIndex].value[i]);
                }
            }

            this.UserProps[contextIndex].value = newContent;
            this.contextIndex = contextIndex;
        },
        submit(){
            this.updateProps({pageCode:this.pageCode, compCode:this.compCode, props:this.UserProps})
            this.$emit('close')
        },
        classReact() {
            let containerCls =
                "bg-secondary mb-4 w-100 preview relative d-flex align-items-center";
            const containIndex = this.UserProps.findIndex(
                prop => prop.name == "Contain"
            );
            if (this.UserProps[containIndex].value) {
                containerCls += " container justify-content-center";
            } else {
                containerCls += " justify-content-around";
            }
            this.containerClass = containerCls;

            let cardCls = "preview-card m-3 d-flex";
            const haIndex = this.UserProps.findIndex(
                prop => prop.name == "Horizontal Align"
            );
            switch (this.UserProps[haIndex].value) {
                case "Left":
                    cardCls += " justify-content-start";
                    break;
                case "Center":
                    cardCls += " justify-content-center";
                    break;
                case "Right":
                    cardCls += " justify-content-end";
                    break;
                default:
                    break;
            }

            const vaIndex = this.UserProps.findIndex(
                prop => prop.name == "Vertical Align"
            );
            switch (this.UserProps[vaIndex].value) {
                case "Top":
                    cardCls += " align-items-start";
                    break;
                case "Center":
                    cardCls += " align-items-center";
                    break;
                case "Bottom":
                    cardCls += " align-items-end";
                    break;
                default:
                    break;
            }

            this.cardClass = cardCls;
        }
    },
    computed: mapGetters(["CardListProps"]),
    updated() {
        this.classReact();
    },
    created() {
        const copy = this.CardListProps.map(prp => {
            if (prp.name == "Content") {
                return { ...prp, value: prp.value };
            } else if (prp.type == "Boolean") {
                return { ...prp, value: prp.value == "true" };
            } else if (prp.type == "Array") {
                return { ...prp, value: prp.value[0] };
            } else {
                return { ...prp, value: "" };
            }
        });

        this.UserProps = copy.map(prp => {
            if (prp.name in this.props) {
                if (prp.type == "Array") {
                    if (typeof this.props[prp.name] == "string" && this.props[prp.name] == "") {
                        return prp;
                    } else {
                        return { ...prp, value: this.props[prp.name] };
                    }
                } else {
                    return { ...prp, value: this.props[prp.name] };
                }
            } else {
                return prp;
            }
        });

        this.classReact();
        this.changePageCount();
    }
};
</script>

<style>
.preview {
    height: 120px;
}

.preview-card {
    height: 50px;
    width: 50px;
    background-color: lightyellow;
}
</style>
