export default function (meilisearchConfig: object, index: string) {
    return {
        query: "",
        index: null as any,
        results: null as any,

        watchQuery(): void {
            this.$watch("query", (query: string) => {
                if (query === "") {
                    this.results = null;
                    return;
                }

                this.search(query);
            });
        },

        async search(query: string): Promise<void> {
            this.results = await this.index.search(query, {});
        },

        init(): void {
            const client = new window.MeiliSearch(meilisearchConfig);

            this.index = client.index(index);
            this.watchQuery();
        },
    };
}
