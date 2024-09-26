import {
    Card,
    Page,
    Layout,
    TextContainer,
    Image,
    BlockStack,
    Frame,
    Banner,
    List,
    Modal,
    Box,
    useIndexResourceState,
    ButtonGroup,
    Icon,
    Toast,
    Tabs,
    TextField,
    EmptySearchResult,
    IndexFiltersMode,
    LegacyCard,
    IndexFilters,
    useSetIndexFiltersMode,
    Pagination,
    InlineStack,
    Loading,
    Badge,
    Button,
    IndexTable,
    Link,
    Text,
} from "@shopify/polaris";

import {TitleBar, useAppBridge} from "@shopify/app-bridge-react";
import SkeletonTable from "../components/SkeletonTable.jsx";
import {
    EditIcon,
    DeleteIcon,
    ExternalSmallIcon,
    ViewIcon

} from "@shopify/polaris-icons";
import { useTranslation, Trans } from "react-i18next";
import React, { useState, useCallback, useEffect, useContext } from "react";
import { trophyImage } from "../assets";
import  rule  from "../assets/rule.png";


import {AppContext, ProductsCard} from "../components";
import {useNavigate} from "react-router-dom";
import {getSessionToken} from "@shopify/app-bridge-utils";
import SetupGuides  from "../components/SetupGuides.jsx";
import axios from "axios";

export default function HomePage() {
    const { t } = useTranslation();
    const appBridge = useAppBridge();
    const { apiUrl } = useContext(AppContext);
    const [modalReassign, setModalReassign] = useState(false);
    const [loading, setLoading] = useState(true);
    const [btnLoading, setBtnLoading] = useState(false);
    const [selected, setSelected] = useState(0);
    const queryParams = new URLSearchParams(location.search);
    const [paginationValue, setPaginationValue] = useState(1);
    const currentPage = parseInt(queryParams.get('page')) || 1;
    const search_value = (queryParams.get('search')) || "";
    const [queryValue, setQueryValue] = useState(search_value);
    const [showClearButton, setShowClearButton] = useState(false);
    const [tableLoading, setTableLoading] = useState(false);
    const [hasNextPage, setHasNextPage] = useState(false);
    const [hasPreviousPage, setHasPreviousPage] = useState(false);
    const [activeDeleteModal, setActiveDeleteModal] = useState(false);
    const [deleteBtnLoading, setDeleteBtnLoading] = useState(false);
    const [toggleLoadData, setToggleLoadData] = useState(true);
    const [modalImage, setModalImage] = useState(null); // Store image URL

    const [appStatus, setAppStatus] = useState(false);
    const [passwordProtected, setPasswordProtected] = useState(false);
    const [linkUrl, setLinkUrl] = useState(null);
    const [builderDetails, setBuilderDetails] = useState([]);
    const {mode, setMode} = useSetIndexFiltersMode(IndexFiltersMode.Filtering);
    const [toastMsg, setToastMsg] = useState('')

    const [ruleID, setRuleID] = useState("");
    const toggleDeleteModalClose = useCallback(() => {
        setActiveDeleteModal((activeDeleteModal) => !activeDeleteModal);
    }, []);
    const onHandleCancel = () => {};
    const navigate = useNavigate();

    // const [rules, setRules] = useState([]);
    const { selectedResources, allResourcesSelected, handleSelectionChange } =
        useIndexResourceState(builderDetails);


    const allResourcesSelect = builderDetails?.every(({ id }) =>
        selectedResources.includes(id)
    );
    const toggleDeleteModal = useCallback((id) => {
        setRuleID(id);
        setActiveDeleteModal((activeDeleteModal) => !activeDeleteModal);
    }, []);



    const fetchData = async () => {
        try {
            setTableLoading(true)
            let sessionToken = await getSessionToken(appBridge);
            const response = await axios.get(
                `${apiUrl}builder-details?status=${
                    selected == 0 ? "all" : selected == 1 ? 1 : 0
                }&search=${queryValue}&page=${paginationValue}`,
                {
                    headers: {
                        Authorization: `Bearer ${sessionToken}`,
                    },
                }
            );

            if (response?.status === 200) {

                setBuilderDetails(response?.data?.data?.data);
                setLoading(false);
                setToggleLoadData(false);
                setHasNextPage(response?.data?.data?.last_page > paginationValue);
                setHasPreviousPage(paginationValue > 1);
            }
        } catch (error) {
            console.error("Error fetching data:", error);
        } finally {
            setLoading(false);
            setTableLoading(false);
        }
    };





    const handlePagination = (value) => {
        if (value == "next") {
            setPaginationValue(paginationValue + 1);
        } else {
            setPaginationValue(paginationValue - 1);
        }
        setLoading(true);
        setToggleLoadData(true);
    };

    const handleDelete = async () => {
        setDeleteBtnLoading(true);
        try {
            let sessionToken = await getSessionToken(appBridge);
            const response = await axios.delete(
                `${apiUrl}delete-rule/${ruleID}`,
                {
                    headers: {
                        Authorization: `Bearer ${sessionToken}`,
                    },
                }
            );
            if (response?.status === 200) {
                setTableLoading(false)
                setSucessToast(true);
                setToastMsg(response?.data?.message);
                setActiveDeleteModal((activeDeleteModal) => !activeDeleteModal);
                setToggleLoadData(true);
                setDeleteBtnLoading(false);
            } else {
                setErrorToast(true);
                setToastMsg(response?.data?.message);
                setDeleteBtnLoading(false);
            }
        } catch (error) {
            setDeleteBtnLoading(false);
            setActiveDeleteModal((activeDeleteModal) => !activeDeleteModal);
        }
    };

    const handleButtonClick = () => {
        if (linkUrl) {
            window.open(linkUrl, '_blank');
        }
    };

    useEffect(() => {
        if (toggleLoadData) {
            fetchData();
        }
    }, [toggleLoadData, selected, queryValue]);




    const emptyStateMarkup = (
        // <EmptySearchResult title={"No Rule Found"} withIllustration />

        <Box padding={"600"}>
            <BlockStack inlineAlign="center">
                <Box maxWidth="100%">
                    <BlockStack inlineAlign="center">
                        <BlockStack gap={300}>
                            <div className="flex justify-center items-center">
                                <img src={rule} width={100} height={48} alt="" />
                            </div>
                            <Text as="p" variant="bodyLg" alignment="center" >
                                No Record has been found
                            </Text>
                            {/*<Text as="p" variant="bodyMd" tone="subdued">*/}
                            {/*    No Rule available. Consider creating a new one to get started!*/}
                            {/*</Text>*/}
                        </BlockStack>
                    </BlockStack>
                </Box>
            </BlockStack>
        </Box>
    );
    function handleRowClick(id) {
        const target = event.target;
        const isCheckbox = target.tagName === "INPUT" && target.type === "checkbox";

        if (!isCheckbox) {
            event.stopPropagation(); // Prevent row from being selected
        } else {
            // Toggle selection state of row
            const index = selectedResources.indexOf(id);
            if (index === -1) {
                handleSelectionChange([...selectedResources, id]);
            } else {
                handleSelectionChange(selectedResources.filter((item) => item !== id));
            }
        }
    }

    const formatDate = (created_at) => {
        const months = [
            "Jan", "Feb", "Mar", "Apr", "May", "Jun",
            "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
        ];

        const date = new Date(created_at);
        const monthName = months[date.getMonth()];
        const day = date.getDate();
        const year = date.getFullYear();

        const formattedDate = `${monthName} ${day}, ${year}`;
        return formattedDate;
    }


    const resourceName = {
        singular: "Builder",
        plural: "Builders",
    };
    const [errorToast, setErrorToast] = useState(false);
    const [sucessToast, setSucessToast] = useState(false);
    const handleReassignCloseAction = () => {
        setUniqueId();
        setSellerEmail("");
        setModalReassign(false);
    };

    const handleFiltersQueryChange = useCallback((value) => {
        setQueryValue(value);
        setToggleLoadData(true);
    }, []);


    const handleInfoModal = (image) => {
        setModalImage(image); // Set the image URL
        setActiveDeleteModal(true); // Open modal
    };

    // ------------------------Toasts Code start here------------------
    const toggleErrorMsgActive = useCallback(() => setErrorToast((errorToast) => !errorToast), []);
    const toggleSuccessMsgActive = useCallback(() => setSucessToast((sucessToast) => !sucessToast), []);


    const toastErrorMsg = errorToast ? (
        <Toast content={toastMsg} error onDismiss={toggleErrorMsgActive} />
    ) : null;

    const toastSuccessMsg = sucessToast ? (
        <Toast content={toastMsg} onDismiss={toggleSuccessMsgActive} />
    ) : null;


    const handleCreateRule = async () => {

        navigate('/CreateRule')

    };

    const [itemStrings, setItemStrings] = useState([
        // "All",
        // "Active",
        // "Inactive",
    ]);

    const tabs = itemStrings.map((item, index) => ({
        content: item,
        index,
        onAction: () => {},
        id: `${item}-${index}`,
        isLocked: index === 0,

    }));

    const handleOrderFilter =async (value) =>  {
        setSelected(value)
        setLoading(true)
        const sessionToken = await getSessionToken(appBridge);

    }



    const rowMarkup = builderDetails?.map(
        (
            {
                id,
                unique_id,
                image,
                email,
                wall_width,
                wall_height,
                wall_unit,
                dun_width,
                dun_height,
                dun_unit,
                form_type,
                show_measurement,
                shape,
                vertical_density,
                horizontal_density,
                created_at,



            },
            index
        ) => (
            <IndexTable.Row
                id={id}
                key={id}
                selected={selectedResources.includes(id)}
                position={index}
                onClick={() => handleRowClick(id)} // Add this line
            >
                <IndexTable.Cell>
                    <div className="capitalize">
                       {unique_id}
                    </div>
                </IndexTable.Cell>

                <IndexTable.Cell>
                    <div className="">
                        <Badge tone="warning" >{email}</Badge>
                    </div>
                </IndexTable.Cell>

                <IndexTable.Cell>{wall_width} { wall_unit}</IndexTable.Cell>
                <IndexTable.Cell>{wall_height} { wall_unit}</IndexTable.Cell>


                <IndexTable.Cell>{dun_width} {dun_unit}</IndexTable.Cell>
                <IndexTable.Cell>{dun_height} {dun_unit}</IndexTable.Cell>
                <IndexTable.Cell>{form_type}</IndexTable.Cell>

                <IndexTable.Cell>
                    {show_measurement === 'true' ? (
                        <Badge tone="success">True</Badge>
                    ) : (
                        <Badge tone="info">False</Badge>
                    )}
                </IndexTable.Cell>

                <IndexTable.Cell>{shape}</IndexTable.Cell>
                <IndexTable.Cell>{vertical_density}</IndexTable.Cell>
                <IndexTable.Cell>{horizontal_density}</IndexTable.Cell>
                <IndexTable.Cell>{created_at != null ? formatDate(created_at) : "---"}</IndexTable.Cell>
                <IndexTable.Cell style={{ textAlign: 'right' }}>
                    <div style={{ display: 'flex', gap: '8px' }}>
                        {/* Button to open modal and pass the image */}
                        {image &&
                            <Button
                                size="large"
                                icon={ViewIcon}
                                onClick={() => handleInfoModal(image)} // Wrap in arrow function
                            />
                        }
                        {/* Button to open the builder link in a new tab */}
                        <Button
                            size="large"
                            icon={ExternalSmallIcon}
                            onClick={() => window.open(`https://a8fcb0-2.myshopify.com/pages/builder?preview=${unique_id}`, '_blank')}
                        />
                    </div>
                </IndexTable.Cell>


            </IndexTable.Row>
        )
    );
    return (

        <>

            <Modal
                size="large"
                open={activeDeleteModal}
                onClose={toggleDeleteModalClose}
                title="Image"
            >
                <Modal.Section>
                    <div
                        style={{
                            position: 'relative',
                            boxSizing: 'content-box',
                            maxWidth: '100%',
                            aspectRatio: '1.8508997429305913',
                        }}
                    >
                        {modalImage && (
                            <img
                                src={modalImage}
                                alt="Preview"
                                style={{ width: '100%', height: 'auto' }}
                            />
                        )}
                    </div>
                </Modal.Section>
            </Modal>
            {loading ? (
                <SkeletonTable />
            ) : (

                <>
                    <Page fullWidth


                        title="Dun Wall Builder"


                    >
                        <Layout>
                            <Layout.Section>
                                <LegacyCard>
                                    <IndexFilters
                                        loading={toggleLoadData}
                                        queryValue={queryValue}
                                        queryPlaceholder="Searching in all"
                                        onQueryChange={handleFiltersQueryChange}
                                        onQueryClear={() => {
                                            setQueryValue("");
                                            setToggleLoadData(true);
                                        }}
                                        cancelAction={{
                                            onAction: onHandleCancel,
                                            disabled: false,
                                            loading: false,
                                        }}
                                        tabs={tabs}

                                        selected={selected}
                                        onSelect={(selected) => {
                                            setSelected(selected);
                                            setToggleLoadData(true);
                                        }}
                                        canCreateNewView={false}
                                        hideFilters
                                        mode={mode}
                                        setMode={setMode}
                                        filteringAccessibilityTooltip="Search"
                                    />
                                    <IndexTable
                                        resourceName={resourceName}
                                        itemCount={builderDetails?.length}
                                        selectable={false}
                                        emptyState={emptyStateMarkup}
                                        loading={tableLoading}
                                        pagination={{
                                            hasPrevious: hasPreviousPage
                                                ? true
                                                : false,
                                            onPrevious: () =>
                                                handlePagination("prev"),
                                            hasNext: hasNextPage ? true : false,
                                            onNext: () => handlePagination("next"),
                                        }}
                                        headings={[

                                            { title: "Preview Id" },
                                            { title: "Email" },
                                            { title: "Wall Width" },
                                            { title: "Wall Height" },
                                            { title: "Dun Width" },
                                            {title:'Dun Height'},
                                            {title:'Form Type'},
                                            {title:'Show Measurement'},
                                            {title:'Shape'},
                                            {title:'Vertical Density'},
                                            {title:'Horizontal Density'},
                                            { title: "Date" },
                                            { title: "Action" },
                                        ]}
                                    >
                                        {rowMarkup}
                                    </IndexTable>
                                </LegacyCard>
                            </Layout.Section>
                            <Layout.Section></Layout.Section>
                            <Layout.Section></Layout.Section>
                        </Layout>

                        {toastErrorMsg}
                        {toastSuccessMsg}
                    </Page>
                </>

            )}
        </>
    );
}
