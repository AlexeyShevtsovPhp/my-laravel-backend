async function search(query) {
    const url = `/monolit/find?search=${query}`;
    const response = await fetch(url);
    const result = await response.json();
    return result.data.map(function (item) {
        return {
            label: item.name,
            value: item.id
        };
    });
}

const autoCompleteJS = new autoComplete({
    placeHolder: "Поиск",
    data: {
        src: async (query) => await search(query),
        cache: false,
        keys: ["label"],
    },
    resultItem: {
        highlight: true
    },
    events: {
        input: {
            selection: (event) => {
                const selectedItem = event.detail.selection.value;

                autoCompleteJS.input.value = selectedItem.label;

                window.location.href = `/monolit/categories/${selectedItem.value}`;
            }
        }
    }

});



