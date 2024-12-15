import { Alpine as AlpineType } from 'alpinejs'

declare global {
    const Alpine: AlpineType
    $page.props.app = {
        name: string,
    };
}
