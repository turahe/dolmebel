declare namespace App.Data {
    export type Blog = {
        id: string;
        title: string;
        content: string;
        author: App.Data.User;
    };
    export type Category = {
        id: string;
        name: string;
        slug: string;
        code: string | null;
        description: string | null;
        image: string;
        icon: string;
        parent_id: string | null;
        count: number | null;
    };
    export type Comment = {
        title: string;
        content: string;
        published_at: string | null;
        author: App.Data.User;
    };
    export type User = {
        id: string;
        username: string;
        email: string;
        avatar: string;
    };
}
declare namespace App.Enums {
    export type PhoneType = 'MOBILE' | 'WORK' | 'OTHER';
}
declare namespace Turahe.Comment.Enums {
    export type CommentType = 'COMMENT' | 'TESTIMONY' | 'TICKET' | 'REVIEW';
}
declare namespace Turahe.Core.Enums {
    export type OrganizationType =
        | 'COMPANY'
        | 'SUPPLIER'
        | 'COMPANY_HOLDING'
        | 'COMPANY_SUBSIDIARY'
        | 'BRANCH'
        | 'OUTLET'
        | 'STORE'
        | 'DEPARTMENT'
        | 'SUB_DEPARTMENT'
        | 'DIVISION'
        | 'SUB_DIVISION'
        | 'DESIGNATION'
        | 'INSTITUTION'
        | 'COMMUNITY'
        | 'ORGANIZATION'
        | 'FOUNDATION'
        | 'BRANCH_OFFICE'
        | 'BRANCH_OUTLET'
        | 'BRANCH_STORE'
        | 'REGIONAL'
        | 'FRANCHISEE'
        | 'PARTNER';
}
