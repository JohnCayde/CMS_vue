<template lang="">
    <div class="modal-body">
        <div class="d-flex flex-column">
            <div class="bg-secondary mb-4 w-100 preview relative">
                <div v-if="logo" :class="PreviewClass">
                    <div class="preview-logo text-center py-2">Logo</div>
                    <div class="d-flex">
                        <h6
                            :class="PreviewTextClass"
                            v-for="(name, index) in pageNames"
                            :key="index"
                        >
                            {{ name }}
                        </h6>
                    </div>
                </div>
                <div v-else :class="PreviewClass">
                    <h6
                        :class="PreviewTextClass"
                        v-for="(name, index) in pageNames"
                        :key="index"
                    >
                        {{ name }}
                    </h6>
                </div>
            </div>
            <table class="table table-bordered w-auto">
                <tr>
                    <th class="no-column-width">No</th>
                    <th class="w-25">Attribute</th>
                    <th class="w-50">Value</th>
                </tr>
                <tr v-for="(prp, idx) in NavBarProps" class="row-height">
                    <!-- No -->
                    <td>{{ idx + 1 }}</td>
                    <!-- prop name -->
                    <td v-if="prp.name == 'Hyperlink'" class="row-height">
                        {{ prp.name }}
                        <button
                            class="btn bg-primary btn-sm sub-btn me-2 py-0 px-1 text-white"
                            @click="newMenu"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="16"
                                height="16"
                                fill="currentColor"
                                class="bi bi-plus"
                                viewBox="0 0 16 16"
                            >
                                <path
                                    d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"
                                />
                            </svg>
                        </button>
                    </td>
                    <td v-else>{{ prp.name }}</td>
                    <!-- prop value -->
                    <td v-if="prp.name == 'Hyperlink'">
                        <ul class="list-group">
                            <li
                                v-for="(menu, index) in UserProps[idx].value"
                                :key="index"
                                class="list-group-item d-flex justify-content-between"
                            >
                                <select class="form-select" v-model="menu.code" @change="refreshMenu">
                                    <option
                                        v-for="(page, x) in AllPages"
                                        :key="x"
                                        :value="page.code"
                                        >{{ page.name }}</option
                                    >
                                </select>
                                <button
                                    class="btn btn-primary text-white mx-1"
                                    :value="index"
                                    @click="rmvMenu"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="16"
                                        height="16"
                                        fill="currentColor"
                                        class="bi bi-x-lg mx-auto"
                                        viewBox="0 0 16 16"
                                    >
                                        <path
                                            d="M1.293 1.293a1 1 0 0 1 1.414 0L8 6.586l5.293-5.293a1 1 0 1 1 1.414 1.414L9.414 8l5.293 5.293a1 1 0 0 1-1.414 1.414L8 9.414l-5.293 5.293a1 1 0 0 1-1.414-1.414L6.586 8 1.293 2.707a1 1 0 0 1 0-1.414z"
                                        />
                                    </svg>
                                </button>
                            </li>
                        </ul>
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
    name: "NavBarProp",
    props: {
        pageCode: String,
        compCode: String,
        props: Object
    },
    data: () => {
        return {
            UserProps: [],
            PreviewClass:
                "preview-menu absolute w-100 d-flex align-items-center container",
            PreviewTextClass: "mx-2",
            logo: false,
            pageNames: []
        };
    },
    methods: {
        ...mapActions(["addMenu", "delMenu", "updateProps"]),
        newMenu() {
            //add an empty array
            this.addMenu({ pageCode: this.pageCode, compCode: this.compCode });
            this.refreshMenu()
        },
        rmvMenu(e) {
            this.delMenu({
                pageCode: this.pageCode,
                compCode: this.compCode,
                menuIndex: e.currentTarget.value
            });
            this.refreshMenu()
        },
        refreshMenu(){
            const linkIdx = this.UserProps.findIndex(
                prp => prp.name == "Hyperlink"
            );

            for (let i = 0; i < this.UserProps[linkIdx].value.length; i++) {
                const pgElement = this.AllPages.find(pg=>pg.code == this.UserProps[linkIdx].value[i].code)
                this.UserProps[linkIdx].value[i].name = pgElement.name
            }

            this.pageNames = this.UserProps[linkIdx].value.map(
                (page) => {
                    // const pgElement = this.AllPages.find(pg=>pg.code == page.code)
                    return page.name
                }
            );
        },
        submit(){
            this.updateProps({pageCode:this.pageCode, compCode:this.compCode, props:this.UserProps})
            this.$emit('close')
        },
        classReact() {
            let default_class =
                "preview-menu absolute w-100 d-flex align-items-center container";

            const hangIdx = this.UserProps.findIndex(prp => prp.name == "Hang");
            if (this.UserProps[hangIdx].value == true) {
                default_class += " mt-4";
            }

            const colorIdx = this.UserProps.findIndex(
                prp => prp.name == "Color"
            );
            switch (this.UserProps[colorIdx].value) {
                case "light red":
                    default_class += " bg-danger";
                    break;
                case "light blue":
                    default_class += " bg-primary";
                    break;
                case "light yellow":
                    default_class += " bg-warning";
                    break;
                default:
                    break;
            }

            const logoIdx = this.UserProps.findIndex(prp => prp.name == "Logo");
            this.logo = this.UserProps[logoIdx].value;

            const alginIdx = this.UserProps.findIndex(
                prp => prp.name == "Text Align"
            );
            switch (this.UserProps[alginIdx].value) {
                case "Left":
                    default_class += " justify-content-start";
                    break;
                case "Center":
                    default_class += " justify-content-center";
                    break;
                case "Right":
                    default_class += " justify-content-end";
                    break;
                case "Seperate":
                    default_class += " justify-content-between";
                    break;
                default:
                    break;
            }

            this.PreviewClass = default_class;

            let text_default_class = "mx-2";
            const fontIdx = this.UserProps.findIndex(
                prp => prp.name == "Text Font"
            );
            switch (this.UserProps[fontIdx].value) {
                case "Italic":
                    text_default_class += " fst-italic";
                    break;
                case "Bold":
                    text_default_class += " fw-bold";
                    break;
                default:
                    text_default_class += " fw-normal";
                    break;
            }

            this.PreviewTextClass = text_default_class;
        }
    },
    computed: mapGetters(["NavBarProps", "AllPages"]),
    updated() {
        this.classReact();
    },
    created() {
        const copy = this.NavBarProps.map(prp => {
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
        this.refreshMenu()
    }
};
</script>

<style>
.preview {
    height: 200px;
}

.preview-menu {
    height: 50px;
}

.preview-logo {
    height: 50px;
    width: 50px;
    border-radius: 50%;
    background-color: lightpink;
}

.preview-text {
    height: 50px;
}

.row-height {
    height: 55px;
}

.no-column-width {
    width: 10%;
}

.sub-btn {
    height: 30px;
}

.input-text {
    font-size: small;
}
</style>
