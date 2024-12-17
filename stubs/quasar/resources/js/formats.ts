import {useFormats} from "./stores/formats"
const f = useFormats()

const formatter = new Intl.NumberFormat("en");

export const currencyFormatter = new Intl.NumberFormat("en-US", {
    style: "currency",
    currency: "SDP",
});

const   dateFormat =  new Intl.DateTimeFormat("en-US", {
            year: "numeric",
            month: "2-digit",
            day: "2-digit",
            hour: "2-digit",
            minute: "2-digit",
            second: "2-digit",
            timeZone: "UTC",
        })

// export const formatDate = (date: Date) => {
//     return new Intl.DateTimeFormat("en-US", {
//         year: "numeric",
//         month: "2-digit",
//         day: "2-digit",
//         hour: "2-digit",
//         minute: "2-digit",
//         second: "2-digit",
//         timeZone: "UTC",
//     }).format(date);
// };
export const detailsText = (val: string, num = f.textLengths) =>
    val != null
        ? val.replace(/(<([^>]+)>)/gi, "").length > num
            ? val
                  .replace(/(<([^>]+)>)/gi, "")
                  .split("", num)
                  .join("") + "..."
            : val.replace(/(<([^>]+)>)/gi, "")
        : "...";

export const formatNumber = (number?: number) => formatter.format(number || 0);
export const formatCurrency = (number? : number) => currencyFormatter.format(number || 0);
export const formatDate = (date: any) => dateFormat.format(date);
