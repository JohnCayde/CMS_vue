<template lang="">
    <div class="modal-body">
        <div class="d-flex flex-column">
            <div class="bg-secondary mb-4 w-100 preview">
                <div
                    id="carouselExampleControls"
                    class="carousel slide h-100"
                    data-bs-ride="carousel"
                >
                    <div class="carousel-inner h-100">
                        <div
                            v-for="(content, index) in UserProps[ContextIndex]
                                .value"
                            :class="
                                index ==
                                UserProps[ContextIndex].value.length - 1
                                    ? 'carousel-item h-100 container active'
                                    : 'carousel-item h-100 container'
                            "
                        >
                            <div :class="PreviewContainer">
                                <div
                                    class="preview-card w-50 d-flex align-items-center"
                                >
                                    {{ content }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <button
                        class="carousel-control-prev"
                        type="button"
                        data-bs-target="#carouselExampleControls"
                        data-bs-slide="prev"
                    >
                        <span
                            class="carousel-control-prev-icon"
                            aria-hidden="true"
                        ></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button
                        class="carousel-control-next"
                        type="button"
                        data-bs-target="#carouselExampleControls"
                        data-bs-slide="next"
                    >
                        <span
                            class="carousel-control-next-icon"
                            aria-hidden="true"
                        ></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
            <table class="table table-bordered w-auto">
                <tr>
                    <th class="no-column-width">No</th>
                    <th class="w-25">Attribute</th>
                    <th class="w-50">Value</th>
                </tr>
                <tr v-for="(prp, idx) in CarouselProps" class="row-height">
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
                            @change="changeSlideCount"
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
    name: "CarouselProp",
    props: {
        pageCode: String,
        compCode: String,
        props: Object
    },
    data: () => {
        return {
            UserProps: [],
            ContextIndex: 0,
            PreviewContainer: ""
        };
    },
    methods: {
        ...mapActions(["updateProps"]),
        changeSlideCount() {
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

            this.ContextIndex = contextIndex;
            this.UserProps[contextIndex].value = [];
            this.$nextTick(() => {
                this.UserProps[contextIndex].value = newContent;
            });
        },
        submit(){
            this.updateProps({pageCode:this.pageCode, compCode:this.compCode, props:this.UserProps})
            this.$emit('close')
        },
        classReact() {
            let containerCls = "preview-container h-100 mx-5 d-flex";
            const haIndex = this.UserProps.findIndex(
                prop => prop.name == "Horizontal Align"
            );
            switch (this.UserProps[haIndex].value) {
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

            const vaIndex = this.UserProps.findIndex(
                prop => prop.name == "Vertical Align"
            );
            switch (this.UserProps[vaIndex].value) {
                case "Top":
                    containerCls += " align-items-start";
                    break;
                case "Center":
                    containerCls += " align-items-center";
                    break;
                case "Bottom":
                    containerCls += " align-items-end";
                    break;
                default:
                    break;
            }

            this.PreviewContainer = containerCls;
        }
    },
    computed: mapGetters(["CarouselProps"]),
    updated() {
        this.classReact();
    },
    created() {
        const copy = this.CarouselProps.map(prp => {
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

        this.ContextIndex = this.UserProps.findIndex(
            prp => prp.name == "Content"
        );

        this.classReact();
    }
};
</script>

<style>
.preview {
    height: 200px;
}

.preview-container {
    width: 80%;
}

.preview-card {
    height: 50px;
    background-color: lightyellow;
}
</style>
