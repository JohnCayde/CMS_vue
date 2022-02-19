import axios from "axios";

const state = {
    pages: [],
};

const getters = {
    AllPages: (state) =>
        state.pages.map((page) => {
            return { page: page.page, name: page.name, code: page.code };
        }),
    AllPageComps: (state) => state.pages,
};

const actions = {
    async getPages({ commit }) {
        const pages = await axios
            .get("/config/getPage")
            .then(({ data }) => {
                return data;
            })
            .catch((err) => {
                console.log("Eror. Refresh one more time or email the admin");
            });

        commit("setAllPages", pages);
    },
    async addPage({ commit }, page) {
        const newPage = await axios
            .post("/config/addPage", page)
            .then(({ data }) => {
                return data;
            });
        commit("setAllPages", newPage);
    },
    async delPage({ commit }, pageno) {
        const delPage = await axios
            .post("/config/delPage", { pageno })
            .then(({ data }) => {
                return data;
            });
        commit("setAllPages", delPage);
    },
    async addComp({ commit }, payload) {
        const newComp = await axios
            .post("/config/addComponent", payload)
            .then(({ data }) => {
                return data;
            });

        commit("setAllPages", newComp);
    },
    async delComp({ commit }, payload) {
        const delComp = await axios
            .post("/config/delComponent", payload)
            .then(({ data }) => {
                return data;
            });

        commit("setAllPages", delComp);
    },
    addMenu({ commit }, payload) {
        commit("addMenu", payload);
    },
    delMenu({ commit }, payload) {
        commit("delMenu", payload);
    },
    async updateProps({ commit }, payload) {
        const upComp = await axios
            .post("/config/upComponent", payload)
            .then(({ data }) => {
                return data;
            });

        commit("setAllPages", upComp);
    },
};

const mutations = {
    setAllPages: (state, pages) => (state.pages = pages),
    addMenu: (state, payload) => {
        const pgidx = state.pages.findIndex(
            (page) => page.code == payload.pageCode
        );
        const cpidx = state.pages[pgidx].components.findIndex(
            (comp) => comp.code == payload.compCode
        );

        return state.pages[pgidx].components[cpidx].props.Hyperlink.push({
            name: state.pages[0].name,
            code: state.pages[0].code,
        });
    },
    delMenu: (state, payload) => {
        const pgidx = state.pages.findIndex(
            (page) => page.code == payload.pageCode
        );
        const cpidx = state.pages[pgidx].components.findIndex(
            (comp) => comp.code == payload.compCode
        );
        return state.pages[pgidx].components[cpidx].props.Hyperlink.splice(
            payload.menuIndex,
            1
        );
    },
};

export default {
    state,
    getters,
    actions,
    mutations,
};
