<template lang="">
    <div class="modal-body">
        <div class="d-flex flex-column">
            <div class="bg-secondary mb-4 w-100 preview px-5 d-flex flex-column overflow-auto">
                <div
                    class="mb-1"
                    v-for="(field, index) in UserProps[fieldIndex].value"
                    :key="index"
                >
                    <label class="form-label">{{ field }}</label>
                    <div class="inputClass w-100 rounded"></div>
                </div>
                <div :class="containerClass">
                    <button :class="btnClass">Submit</button>
                </div>
            </div>
            <table class="table table-bordered w-auto">
                <tr>
                    <th class="no-column-width">No</th>
                    <th class="w-25">Attribute</th>
                    <th class="w-50">Value</th>
                </tr>
                <tr v-for="(prp, idx) in EnquiryProps" class="row-height">
                    <!-- No -->
                    <td>{{ idx + 1 }}</td>
                    <!-- prop name -->
                    <td>{{ prp.name }}</td>
                    <!-- prop value -->
                    <td v-if="prp.name == 'Field'">
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
                            @change="changeFieldCount"
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
                    <td v-else></td>
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
    name: "EnquiryProp",
    props: {
        pageCode: String,
        compCode: String,
        props: Object
    },
    data: () => {
        return {
            UserProps: [],
            fieldIndex: 0,
            btnClass: "",
            containerClass: ""
        };
    },
    methods: {
        ...mapActions(["updateProps"]),
        changeFieldCount() {
            const countIndex = this.UserProps.findIndex(
                prop => prop.name == "Count"
            );

            const count = Number.parseInt(this.UserProps[countIndex].value);
            const originalCount = this.UserProps[countIndex].value.length;
            let newContent = [];
            if (originalCount < count) {
                for (let i = 0; i < count; i++) {
                    if (originalCount > i) {
                        newContent.push(
                            this.UserProps[this.fieldIndex].value[i]
                        );
                    } else {
                        newContent.push("");
                    }
                }
            } else {
                for (let i = 0; i < count; i++) {
                    newContent.push(this.UserProps[this.fieldIndex].value[i]);
                }
            }

            this.UserProps[this.fieldIndex].value = [];
            this.$nextTick(() => {
                this.UserProps[this.fieldIndex].value = newContent;
            });
        },
        submit() {
            this.updateProps({
                pageCode: this.pageCode,
                compCode: this.compCode,
                props: this.UserProps
            });
            this.$emit("close");
        },
        classReact() {
            let containerCls = "d-flex mt-3";
            const baIndex = this.UserProps.findIndex(
                prop => prop.name == "Button Align"
            );
            switch (this.UserProps[baIndex].value) {
                case "Left":
                    containerCls += " justify-content-start";
                    break;
                case "Center":
                    containerCls += " justify-content-center";
                    break;
                case "Right":
                    containerCls += " justify-content-end";
                    break;
                default:
                    break;
            }
            this.containerClass = containerCls;

            let btnCls = "btn";
            const btnColorIndex = this.UserProps.findIndex(
                prp => prp.name == "Button Colour"
            );
            switch (this.UserProps[btnColorIndex].value) {
                case "light red":
                    btnCls += " btn-danger";
                    break;
                case "light blue":
                    btnCls += " btn-primary";
                    break;
                case "light yellow":
                    btnCls += " btn-warning";
                    break;
                default:
                    break;
            }

            this.btnClass = btnCls;
        }
    },
    computed: mapGetters(["EnquiryProps"]),
    updated() {
        this.classReact();
    },
    created() {
        const copy = this.EnquiryProps.map(prp => {
            if (prp.type == "Boolean") {
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
                    if (
                        typeof this.props[prp.name] == "string" &&
                        this.props[prp.name] == ""
                    ) {
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

        const fieldIndex = this.UserProps.findIndex(
            prop => prop.name == "Field"
        );
        this.fieldIndex = fieldIndex;
        this.classReact();
    }
};
</script>

<style>
.preview {
    height: 200px;
}

.inputClass {
    height: 20px;
    background-color: lightyellow;
}
</style>
