import axios from "axios";

const state = {
    components: [],
};

const getters = {
    AllComps: (state) => state.components,
    NavBarProps: (state) =>
        state.components.find((comp) => comp.name == "navbar").props,
    CardListProps: (state) =>
        state.components.find((comp) => comp.name == "cards").props,
    CarouselProps: (state) =>
        state.components.find((comp) => comp.name == "carousel").props,
    EnquiryProps: (state) =>
        state.components.find((comp) => comp.name == "enquiry").props,
};

const actions = {
    async getComps({ commit }) {
        const components = await axios
            .get("/config/getComponent")
            .then(({ data }) => {
                return data;
            })
            .catch((err) => {
                console.log("Eror. Refresh one more time or email the admin");
            });

        commit("setAllComps", components);
    },
};

const mutations = {
    setAllComps: (state, comps) => (state.components = comps),
};

export default {
    state,
    getters,
    actions,
    mutations,
};
