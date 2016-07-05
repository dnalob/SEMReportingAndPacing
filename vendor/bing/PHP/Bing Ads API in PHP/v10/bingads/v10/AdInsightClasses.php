<?php
// Generated on 3/30/2016 6:11:25 AM

namespace BingAds\v10\AdInsight
{
    use DateTime;

    final class AdInsightServiceSettings
    {
        const ServiceNamespace = 'Microsoft.Advertiser.AdInsight.Api.Service';
        const ProductionEndpoint = 'https://adinsight.api.bingads.microsoft.com/Api/Advertiser/AdInsight/V10/AdInsightService.svc';
        const SandboxEndpoint = 'https://adinsight.api.sandbox.bingads.microsoft.com/Api/Advertiser/AdInsight/V10/AdInsightService.svc';
    }

    /**
     * Defines the possible bid opportunity types you can request when calling GetBidOpportunities.
     * @link http://msdn.microsoft.com/en-us/library/mt219343(v=msads.100).aspx BidOpportunityType Value Set
     * 
     * @used-by GetBidOpportunitiesRequest
     */
    final class BidOpportunityType
    {
        /** The bid opportunity may lead to ads shown in one of the first page positions of search results. */
        const FirstPage = 'FirstPage';

        /** The bid opportunity may lead to ads shown in one of the mainline positions of search results. */
        const MainLine = 'MainLine';

        /** The bid opportunity may lead to ads shown in the first mainline position of search results. */
        const MainLine1 = 'MainLine1';
    }

    /**
     * Defines the possible values of a campaign budget point.
     * @link http://msdn.microsoft.com/en-us/library/mt219327(v=msads.100).aspx BudgetPointType Value Set
     * 
     * @used-by BudgetPoint
     */
    final class BudgetPointType
    {
        /** The budget point includes the current budget. */
        const Current = 'Current';

        /** The budget point includes the optimal suggested budget. */
        const Suggested = 'Suggested';

        /** The budget point includes the proposed budget which is estimated to yield the maximum number of clicks. */
        const Maximum = 'Maximum';

        /** The budget point includes a proposed budget other than current, maximum, or suggested. */
        const Other = 'Other';
    }

    /**
     * Defines the possible types of campaign budgets.
     * @link http://msdn.microsoft.com/en-us/library/mt219344(v=msads.100).aspx BudgetLimitType Value Set
     * 
     * @used-by BudgetOpportunity
     */
    final class BudgetLimitType
    {
        /** A monthly budget that is spent until it is depleted. */
        const MonthlyBudgetSpendUntilDepleted = 'MonthlyBudgetSpendUntilDepleted';

        /** A daily budget that is spread throughout the day. */
        const DailyBudgetStandard = 'DailyBudgetStandard';

        /** A daily budget that is spent until it is depleted. */
        const DailyBudgetAccelerated = 'DailyBudgetAccelerated';
    }

    /**
     * Defines the possible keyword opportunity types you can request when calling GetKeywordOpportunities.
     * @link http://msdn.microsoft.com/en-us/library/mt219346(v=msads.100).aspx KeywordOpportunityType Value Set
     * 
     * @used-by GetKeywordOpportunitiesRequest
     */
    final class KeywordOpportunityType
    {
        /** The keyword opportunity will be suggested based on the marketplace impact of adding keywords with the broad match type. */
        const BroadMatch = 'BroadMatch';

        /** The keyword opportunity will be suggested based on the full context of the campaign, including existing keywords, landing page, and ad copy. */
        const CampaignContext = 'CampaignContext';
    }

    /**
     * Defines the possible positions where you can target an ad to appear in the search results or on a content-based webpage.
     * @link http://msdn.microsoft.com/en-us/library/mt219330(v=msads.100).aspx TargetAdPosition Value Set
     * 
     * @used-by GetEstimatedBidByKeywordIdsRequest
     * @used-by GetEstimatedBidByKeywordsRequest
     */
    final class TargetAdPosition
    {
        /** Target the first position at the top of the search results page. */
        const MainLine1 = 'MainLine1';

        /** Target the second, third, and fourth positions at the top of the search results page. */
        const MainLine = 'MainLine';

        /** Target any position on the right side of the search results page. */
        const SideBar = 'SideBar';
    }

    /**
     * Defines a selection of currency values.
     * @link http://msdn.microsoft.com/en-us/library/mt219340(v=msads.100).aspx Currency Value Set
     * 
     * @used-by BidLandscapePoint
     * @used-by EstimatedBidAndTraffic
     * @used-by EstimatedPositionAndTraffic
     * @used-by GetEstimatedBidByKeywordsRequest
     * @used-by GetEstimatedPositionByKeywordsRequest
     */
    final class Currency
    {
        const AlgerianDinar = 'AlgerianDinar';
        const ArgentinePeso = 'ArgentinePeso';
        const ArmenianDram = 'ArmenianDram';
        const AustralianDollar = 'AustralianDollar';
        const AzerbaijanianManat = 'AzerbaijanianManat';
        const BahrainiDinar = 'BahrainiDinar';
        const Baht = 'Baht';
        const Balboa = 'Balboa';
        const BelarussianRuble = 'BelarussianRuble';
        const BelizeDollar = 'BelizeDollar';
        const Bolivar = 'Bolivar';
        const Boliviano = 'Boliviano';
        const BrazilianReal = 'BrazilianReal';
        const BruneiDollar = 'BruneiDollar';
        const CanadianDollar = 'CanadianDollar';
        const ChileanPeso = 'ChileanPeso';
        const ColombianPeso = 'ColombianPeso';
        const CordobaOro = 'CordobaOro';
        const CostaRicanColon = 'CostaRicanColon';
        const Croatiankuna = 'Croatiankuna';
        const CzechKoruna = 'CzechKoruna';
        const DanishKrone = 'DanishKrone';
        const Denar = 'Denar';
        const DominicanPeso = 'DominicanPeso';
        const Dong = 'Dong';
        const EgyptianPound = 'EgyptianPound';
        const Euro = 'Euro';
        const Forint = 'Forint';
        const Guarani = 'Guarani';
        const HongKongDollar = 'HongKongDollar';
        const Hryvnia = 'Hryvnia';
        const IcelandKrona = 'IcelandKrona';
        const IndianRupee = 'IndianRupee';
        const IranianRial = 'IranianRial';
        const IraqiDinar = 'IraqiDinar';
        const JamaicanDollar = 'JamaicanDollar';
        const JapaneseYen = 'JapaneseYen';
        const JordanianDinar = 'JordanianDinar';
        const KenyanShilling = 'KenyanShilling';
        const Kroon = 'Kroon';
        const KuwaitiDinar = 'KuwaitiDinar';
        const Lari = 'Lari';
        const LatvianLats = 'LatvianLats';
        const LebanesePound = 'LebanesePound';
        const Lek = 'Lek';
        const Lempira = 'Lempira';
        const Leu = 'Leu';
        const Lev = 'Lev';
        const LibyanDinar = 'LibyanDinar';
        const LithuanianLitus = 'LithuanianLitus';
        const MalaysianRinggit = 'MalaysianRinggit';
        const MexicanPeso = 'MexicanPeso';
        const MoroccanDirham = 'MoroccanDirham';
        const NewIsraeliSheqel = 'NewIsraeliSheqel';
        const NewTaiwanDollar = 'NewTaiwanDollar';
        const NewZealandDollar = 'NewZealandDollar';
        const NorwegianKrone = 'NorwegianKrone';
        const NuevoSol = 'NuevoSol';
        const PakistanRupee = 'PakistanRupee';
        const Pataca = 'Pataca';
        const PesoUruguayo = 'PesoUruguayo';
        const PhilippinePeso = 'PhilippinePeso';
        const QatariRial = 'QatariRial';
        const Quetzal = 'Quetzal';
        const RialOmani = 'RialOmani';
        const Rufiyaa = 'Rufiyaa';
        const Rupiah = 'Rupiah';
        const RussianRuble = 'RussianRuble';
        const SaudiRiyal = 'SaudiRiyal';
        const SingaporeDollar = 'SingaporeDollar';
        const SlovakKoruna = 'SlovakKoruna';
        const Som = 'Som';
        const SouthAfricanRand = 'SouthAfricanRand';
        const SwedishKrona = 'SwedishKrona';
        const SwissFranc = 'SwissFranc';
        const SyrianPound = 'SyrianPound';
        const Tenge = 'Tenge';
        const Tolar = 'Tolar';
        const TrinidadandTobagoDollar = 'TrinidadandTobagoDollar';
        const Tugrik = 'Tugrik';
        const TunisianDinar = 'TunisianDinar';
        const TurkishLira = 'TurkishLira';
        const UAEDirham = 'UAEDirham';
        const UKPound = 'UKPound';
        const USDollar = 'USDollar';
        const UzbekistanSum = 'UzbekistanSum';
        const Won = 'Won';
        const YemeniRial = 'YemeniRial';
        const YuanRenminbi = 'YuanRenminbi';
        const YugoslavianNewDinar = 'YugoslavianNewDinar';
        const ZimbabweDollar = 'ZimbabweDollar';
        const Zloty = 'Zloty';
    }

    /**
     * Defines the possible keyword match type values.
     * @link http://msdn.microsoft.com/en-us/library/mt219349(v=msads.100).aspx MatchType Value Set
     * 
     * @used-by EstimatedBidAndTraffic
     * @used-by EstimatedPositionAndTraffic
     * @used-by KeywordAndMatchType
     * @used-by KeywordKPI
     * @used-by GetEstimatedPositionByKeywordsRequest
     * @used-by GetHistoricalKeywordPerformanceRequest
     */
    final class MatchType
    {
        /** An exact match results when all of the words in the keyword exactly match the user's search query. */
        const Exact = 'Exact';

        /** A phrase match results when all of the words in the keyword are present in the user's search query and are in the same order. */
        const Phrase = 'Phrase';

        /** A broad match results when words in the keyword are present in the user's search query; however, the word order can vary. */
        const Broad = 'Broad';

        /** A content match results when the keywords extracted from the content webpage match the keywords in the user's search query by using an exact match comparison. */
        const Content = 'Content';

        /** Aggregates the data across all match types. */
        const Aggregate = 'Aggregate';
    }

    /**
     * Defines the possible values that indicate whether all or a subset of an ad group's existing keywords are used to determine the bid landscape.
     * @link http://msdn.microsoft.com/en-us/library/mt219323(v=msads.100).aspx AdGroupBidLandscapeType Value Set
     * 
     * @used-by AdGroupBidLandscape
     * @used-by AdGroupBidLandscapeInput
     */
    final class AdGroupBidLandscapeType
    {
        /** All of an ad group's existing keywords are used to determine the bid landscape. */
        const Uniform = 'Uniform';

        /** Only existing keywords that use the ad group's default bid are used to determine the bid landscape. */
        const DefaultBidOnly = 'DefaultBidOnly';
    }

    /**
     * Defines the possible time periods that determine the pool of data that the service uses to get the performance statistics of a keyword.
     * @link http://msdn.microsoft.com/en-us/library/mt219339(v=msads.100).aspx TimeInterval Value Set
     * 
     * @used-by GetHistoricalKeywordPerformanceRequest
     */
    final class TimeInterval
    {
        /** Use data from the previous calendar month. */
        const LastMonth = 'LastMonth';

        /** Use data from last week, Sunday through Saturday. */
        const LastWeek = 'LastWeek';

        /** Use data from yesterday. */
        const LastDay = 'LastDay';
    }

    /**
     * Defines the possible positions of an ad in the search results or on a content-based webpage.
     * @link http://msdn.microsoft.com/en-us/library/mt219338(v=msads.100).aspx AdPosition Value Set
     * 
     * @used-by KeywordKPI
     * @used-by GetHistoricalKeywordPerformanceRequest
     */
    final class AdPosition
    {
        /** Indicates all search result positions. */
        const All = 'All';

        /** The first ad to appear at the top of the search results page. */
        const MainLine1 = 'MainLine1';

        /** The second ad to appear at the top of the search results page. */
        const MainLine2 = 'MainLine2';

        /** The third ad to appear at the top of the search results page. */
        const MainLine3 = 'MainLine3';

        /** The fourth ad to appear at the top of the search results page. */
        const MainLine4 = 'MainLine4';

        /** The first ad to appear on the right side of the first search results page. */
        const SideBar1 = 'SideBar1';

        /** The second ad to appear on the right side of the first search results page. */
        const SideBar2 = 'SideBar2';

        /** The third ad to appear on the right side of the first search results page. */
        const SideBar3 = 'SideBar3';

        /** The fourth ad to appear on the right side of the first search results page. */
        const SideBar4 = 'SideBar4';

        /** The fifth ad to appear on the right side of the first search results page. */
        const SideBar5 = 'SideBar5';

        /** The sixth ad to appear on the right side of the first search results page. */
        const SideBar6 = 'SideBar6';

        /** The seventh ad to appear on the right side of the first search results page. */
        const SideBar7 = 'SideBar7';

        /** The eighth ad to appear on the right side of the first search results page. */
        const SideBar8 = 'SideBar8';

        /** The ninth ad to appear on the right side of the first search results page. */
        const SideBar9 = 'SideBar9';

        /** The tenth ad to appear on the right side of the first search results page. */
        const SideBar10 = 'SideBar10';

        /** Aggregates the data for all supported positions. */
        const Aggregate = 'Aggregate';
    }

    final class Field
    {
        const UNKNOW = 'UNKNOW';
        const BidLandscape = 'BidLandscape';
        const BidSuggestion = 'BidSuggestion';
        const EntityAuctionInsight = 'EntityAuctionInsight';
        const AggregatedAuctionInsight = 'AggregatedAuctionInsight';
        const AuctionInsightAvailableChildren = 'AuctionInsightAvailableChildren';
        const TopMover = 'TopMover';
        const AccountId = 'AccountId';
        const CampaignId = 'CampaignId';
        const AdGroupId = 'AdGroupId';
        const KeywordId = 'KeywordId';
        const TimeInterval = 'TimeInterval';
    }

    final class SortOrder
    {
        const ASCENDING = 'ASCENDING';
        const DESCENDING = 'DESCENDING';
    }

    final class Operator
    {
        const EQUALS = 'EQUALS';
        const NOT_EQUALS = 'NOT_EQUALS';
        const IN = 'IN';
        const NOT_IN = 'NOT_IN';
        const GREATER_THAN = 'GREATER_THAN';
        const GREATER_THAN_EQUALS = 'GREATER_THAN_EQUALS';
        const LESS_THAN = 'LESS_THAN';
        const LESS_THAN_EQUALS = 'LESS_THAN_EQUALS';
        const STARTS_WITH = 'STARTS_WITH';
        const STARTS_WITH_IGNORE_CASE = 'STARTS_WITH_IGNORE_CASE';
        const CONTAINS = 'CONTAINS';
        const CONTAINS_IGNORE_CASE = 'CONTAINS_IGNORE_CASE';
        const DOES_NOT_CONTAIN = 'DOES_NOT_CONTAIN';
        const DOES_NOT_CONTAIN_IGNORE_CASE = 'DOES_NOT_CONTAIN_IGNORE_CASE';
        const UNKNOWN = 'UNKNOWN';
    }

    /**
     * Defines an error object that contains the details that explain why the service operation failed.
     * @link http://msdn.microsoft.com/en-us/library/mt219318(v=msads.100).aspx AdApiError Data Object
     * 
     * @used-by AdApiFaultDetail
     */
    final class AdApiError
    {
        /**
         * A numeric error code that identifies the error.
         * @var integer
         */
        public $Code;

        /**
         * A message that contains additional details about the error.
         * @var string
         */
        public $Detail;

        /**
         * A symbolic string constant that identifies the error.
         * @var string
         */
        public $ErrorCode;

        /**
         * A message that describes the error.
         * @var string
         */
        public $Message;
    }

    /**
     * Defines the base object from which all fault detail objects derive.
     * @link http://msdn.microsoft.com/en-us/library/mt219309(v=msads.100).aspx ApplicationFault Data Object
     */
    class ApplicationFault
    {
        /**
         * The identifier of the log entry that contains the details of the API call.
         * @var string
         */
        public $TrackingId;
    }

    /**
     * Defines a fault object that operations return when generic errors occur, such as an authentication error.
     * @link http://msdn.microsoft.com/en-us/library/mt219306(v=msads.100).aspx AdApiFaultDetail Data Object
     * 
     * @uses AdApiError
     */
    final class AdApiFaultDetail extends ApplicationFault
    {
        /**
         * An array of AdApiError objects that contains the details that explain why the service operation failed.
         * @var AdApiError[]
         */
        public $Errors;
    }

    /**
     * Defines an object that contains a list of estimated clicks, cost, and impressions from 1 to 7 days for the ad group identifier given the suggested bid.
     * @link http://msdn.microsoft.com/en-us/library/mt219312(v=msads.100).aspx AdGroupBidLandscape Data Object
     * 
     * @uses AdGroupBidLandscapeType
     * @uses DayMonthAndYear
     * @uses BidLandscapePoint
     * @used-by GetBidLandscapeByAdGroupIdsResponse
     */
    final class AdGroupBidLandscape
    {
        /**
         * The ad group identifier.
         * @var integer
         */
        public $AdGroupId;

        /**
         * Indicates whether all or a subset of an ad group's existing keywords were used to determine the bid landscape.
         * @var AdGroupBidLandscapeType
         */
        public $AdGroupBidLandscapeType;

        /**
         * The first date used to calculate the bid landscape.
         * @var DayMonthAndYear
         */
        public $StartDate;

        /**
         * The most recent date used to calculate the bid landscape.
         * @var DayMonthAndYear
         */
        public $EndDate;

        /**
         * The list of the total estimated clicks, cost, and impressions from StartDate to EndDate given the suggested bid.
         * @var BidLandscapePoint[]
         */
        public $BidLandscapePoints;
    }

    /**
     * Defines an object that contains the requested bid landscape type for the corresponding ad group identifier.
     * @link http://msdn.microsoft.com/en-us/library/mt219326(v=msads.100).aspx AdGroupBidLandscapeInput Data Object
     * 
     * @uses AdGroupBidLandscapeType
     * @used-by GetBidLandscapeByAdGroupIdsRequest
     */
    final class AdGroupBidLandscapeInput
    {
        /**
         * Determines whether all or a subset of an ad group's existing keywords should be used to determine the bid landscape.
         * @var AdGroupBidLandscapeType
         */
        public $AdGroupBidLandscapeType;

        /**
         * The ad group identifier.
         * @var integer
         */
        public $AdGroupId;
    }

    /**
     * Defines a fault object that operations return when web service-specific errors occur, such as when the request message contains incomplete or invalid data.
     * @link http://msdn.microsoft.com/en-us/library/mt219317(v=msads.100).aspx ApiFaultDetail Data Object
     * 
     * @uses BatchError
     * @uses OperationError
     */
    final class ApiFaultDetail extends ApplicationFault
    {
        /**
         * An array of BatchError objects that identifies the items in the batch of items in the request message that caused the operation to fail.
         * @var BatchError[]
         */
        public $BatchErrors;

        /**
         * An array of OperationError objects that contains the reasons that explain why the service operation failed when the error is not related to a specific item in the batch of items.
         * @var OperationError[]
         */
        public $OperationErrors;
    }

    final class AuctionInsightKPINode
    {
        public $DimensionNames;
        public $ImpressionShare;
        public $OverlapRate;
        public $AveragePosition;
        public $AboveRate;
        public $TopOfPageRate;
    }

    final class AuctionInsightResult
    {
        public $TotalNumEntries;
        public $Entries;
        public $UsedImpressions;
        public $UsedKeywords;
    }

    final class AuctionInsightV2Entity
    {
        public $DisplayDomain;
        public $AggregatedKPI;
        public $KPIs;
    }

    /**
     * Defines an error object that identifies the item within the batch of items in the request message that caused the operation to fail, and describes the reason for the failure.
     * @link http://msdn.microsoft.com/en-us/library/mt219322(v=msads.100).aspx BatchError Data Object
     * 
     * @used-by ApiFaultDetail
     */
    final class BatchError
    {
        /**
         * A numeric error code that identifies the error.
         * @var integer
         */
        public $Code;

        /**
         * A message that provides additional details about the batch error.
         * @var string
         */
        public $Details;

        /**
         * A symbolic string constant that identifies the error.
         * @var string
         */
        public $ErrorCode;

        /**
         * The zero-based index of the item in the batch of items in the request message that failed.
         * @var integer
         */
        public $Index;

        /**
         * A message that describes the error.
         * @var string
         */
        public $Message;
    }

    /**
     * Defines an object that contains estimates of clicks, cost, and impressions given the suggested bid.
     * @link http://msdn.microsoft.com/en-us/library/mt219314(v=msads.100).aspx BidLandscapePoint Data Object
     * 
     * @uses Currency
     * @used-by AdGroupBidLandscape
     * @used-by KeywordBidLandscape
     */
    final class BidLandscapePoint
    {
        /**
         * The suggested bid value.
         * @var double
         */
        public $Bid;

        /**
         * The estimated number of clicks.
         * @var double
         */
        public $Clicks;

        /**
         * The estimated number of impressions.
         * @var integer
         */
        public $Impressions;

        /**
         * The estimated number of impressions in the top or mainline ad results.
         * @var integer
         */
        public $TopImpressions;

        /**
         * The monetary unit of the suggested bid value and estimated performance statistics.
         * @var Currency
         */
        public $Currency;

        /**
         * The estimated cost.
         * @var double
         */
        public $Cost;

        /**
         * Reserved for future use.
         * @var double
         */
        public $MarginalCPC;
    }

    /**
     * This is the base class from which opportunity objects derive.
     * @link http://msdn.microsoft.com/en-us/library/mt219304(v=msads.100).aspx Opportunity Data Object
     */
    class Opportunity
    {
        /**
         * An identifier that uniquely identifies the opportunity.
         * @var string
         */
        public $OpportunityKey;
    }

    /**
     * Defines an object that contains the suggested bid with estimated clicks and impressions opportunities.
     * @link http://msdn.microsoft.com/en-us/library/mt219336(v=msads.100).aspx BidOpportunity Data Object
     * 
     * @used-by GetBidOpportunitiesResponse
     */
    final class BidOpportunity extends Opportunity
    {
        /**
         * The identifier of the ad group that owns the keyword.
         * @var integer
         */
        public $AdGroupId;

        /**
         * The identifier of the campaign for the ad group that owns the keyword.
         * @var integer
         */
        public $CampaignId;

        /**
         * The current keyword bid amount specified for the match type in the MatchType element.
         * @var double
         */
        public $CurrentBid;

        /**
         * The estimated clicks opportunities corresponding to the suggested bid.
         * @var double
         */
        public $EstimatedIncreaseInClicks;

        /**
         * The estimated increase in spend corresponding to the suggested bid.
         * @var double
         */
        public $EstimatedIncreaseInCost;

        /**
         * The estimated impressions opportunities corresponding to the suggested bid.
         * @var integer
         */
        public $EstimatedIncreaseInImpressions;

        /**
         * The identifier of the keyword to which the bid opportunity applies.
         * @var integer
         */
        public $KeywordId;

        /**
         * The match type to which the suggested bid value applies.
         * @var string
         */
        public $MatchType;

        /**
         * The suggested bid based on the last 7 days of performance history for the corresponding ad group.
         * @var double
         */
        public $SuggestedBid;
    }

    /**
     * Defines an object that contains a suggested keyword and bid value.
     * @link http://msdn.microsoft.com/en-us/library/mt219316(v=msads.100).aspx KeywordOpportunity Data Object
     * 
     * @used-by GetKeywordOpportunitiesResponse
     */
    class KeywordOpportunity extends Opportunity
    {
        /**
         * The identifier of the ad group to apply the suggested keyword to.
         * @var integer
         */
        public $AdGroupId;

        /**
         * The name of the ad group to apply the suggested keyword to.
         * @var string
         */
        public $AdGroupName;

        /**
         * The identifier of the campaign that owns the ad group.
         * @var integer
         */
        public $CampaignId;

        /**
         * The name of the campaign that owns the ad group.
         * @var string
         */
        public $CampaignName;

        /**
         * An indicator of competitive bids for this keyword relative to all search keywords.
         * @var double
         */
        public $Competition;

        /**
         * Estimated increase in clicks if the opportunity is applied.
         * @var double
         */
        public $EstimatedIncreaseInClicks;

        /**
         * Estimated increase in cost if the opportunity is applied.
         * @var double
         */
        public $EstimatedIncreaseInCost;

        /**
         * Estimated increase in impressions if the opportunity is applied.
         * @var integer
         */
        public $EstimatedIncreaseInImpressions;

        /**
         * The match type that the suggested bid applies to.
         * @var integer
         */
        public $MatchType;

        /**
         * The estimated monthly volume of user search queries that may match the suggested keyword for the corresponding MatchType element.
         * @var integer
         */
        public $MonthlySearches;

        /**
         * The suggested bid that may result in your ads serving on the first page of the search query results.
         * @var double
         */
        public $SuggestedBid;

        /**
         * The suggested keyword.
         * @var string
         */
        public $SuggestedKeyword;
    }

    /**
     * Defines an object that contains the marketplace impact statistics of including broad match type keyword bids.
     * @link http://msdn.microsoft.com/en-us/library/mt219315(v=msads.100).aspx BroadMatchKeywordOpportunity Data Object
     * 
     * @uses BroadMatchSearchQueryKPI
     */
    final class BroadMatchKeywordOpportunity extends KeywordOpportunity
    {
        /**
         * Broad match average CPC in the marketplace.
         * @var double
         */
        public $AverageCPC;

        /**
         * Broad match average CTR in the marketplace.
         * @var double
         */
        public $AverageCTR;

        /**
         * Broad match click share in the marketplace.
         * @var double
         */
        public $ClickShare;

        /**
         * Broad match impression share in the marketplace.
         * @var double
         */
        public $ImpressionShare;

        /**
         * The bid of an existing reference keyword used by the service to offer the keyword opportunity.
         * @var double
         */
        public $ReferenceKeywordBid;

        /**
         * The identifier of an existing reference keyword used by the service to offer the keyword opportunity.
         * @var integer
         */
        public $ReferenceKeywordId;

        /**
         * The match type of an existing reference keyword used by the service to offer the keyword opportunity.
         * @var integer
         */
        public $ReferenceKeywordMatchType;

        /**
         * A list of up to three broad match search query KPI objects.
         * @var BroadMatchSearchQueryKPI[]
         */
        public $SearchQueryKPIs;
    }

    /**
     * Defines an object that contains search query statistics of including broad match type keyword bids.
     * @link http://msdn.microsoft.com/en-us/library/mt219329(v=msads.100).aspx BroadMatchSearchQueryKPI Data Object
     * 
     * @used-by BroadMatchKeywordOpportunity
     */
    final class BroadMatchSearchQueryKPI
    {
        /**
         * The average CTR for the search query.
         * @var double
         */
        public $AverageCTR;

        /**
         * The clicks for the search query.
         * @var double
         */
        public $Clicks;

        /**
         * The impressions for the search query.
         * @var integer
         */
        public $Impressions;

        /**
         * The SRPV for the search query.
         * @var integer
         */
        public $SRPV;

        /**
         * The search query corresponding to the keyword.
         * @var string
         */
        public $SearchQuery;
    }

    /**
     * Defines an object that contains the suggested budget with estimated clicks and impressions opportunities.
     * @link http://msdn.microsoft.com/en-us/library/mt219334(v=msads.100).aspx BudgetOpportunity Data Object
     * 
     * @uses BudgetPoint
     * @uses BudgetLimitType
     * @used-by GetBudgetOpportunitiesResponse
     */
    final class BudgetOpportunity extends Opportunity
    {
        /**
         * The list of budget points with weekly impressions, clicks and cost estimates for the given budget amount.
         * @var BudgetPoint[]
         */
        public $BudgetPoints;

        /**
         * The type of budget that the campaign uses.
         * @var BudgetLimitType
         */
        public $BudgetType;

        /**
         * The identifier of the campaign to which the suggested budget applies.
         * @var integer
         */
        public $CampaignId;

        /**
         * The campaign's current budget.
         * @var double
         */
        public $CurrentBudget;

        /**
         * The estimated clicks opportunities corresponding to the suggested budget.
         * @var double
         */
        public $IncreaseInClicks;

        /**
         * The estimated impressions opportunities corresponding to the suggested budget.
         * @var integer
         */
        public $IncreaseInImpressions;

        /**
         * The estimated percentage increase in clicks corresponding to the suggested budget.
         * @var integer
         */
        public $PercentageIncreaseInClicks;

        /**
         * The estimated percentage increase in impressions corresponding to the suggested budget.
         * @var integer
         */
        public $PercentageIncreaseInImpressions;

        /**
         * The suggested budget based on the last 15 days of performance history for the corresponding campaign.
         * @var double
         */
        public $RecommendedBudget;
    }

    /**
     * Defines an object that contains a budget amount and an estimate of weekly impressions, clicks, and cost for this budget amount.
     * @link http://msdn.microsoft.com/en-us/library/mt219337(v=msads.100).aspx BudgetPoint Data Object
     * 
     * @uses BudgetPointType
     * @used-by BudgetOpportunity
     */
    final class BudgetPoint
    {
        /**
         * A potential new budget.
         * @var double
         */
        public $BudgetAmount;

        /**
         * The type of budget relative to a list of budget points.
         * @var BudgetPointType
         */
        public $BudgetPointType;

        /**
         * The estimated weekly clicks for the given budget amount.
         * @var double
         */
        public $EstimatedWeeklyClicks;

        /**
         * The estimated weekly cost for the given budget amount.
         * @var double
         */
        public $EstimatedWeeklyCost;

        /**
         * The estimated weekly impressions for the given budget amount.
         * @var double
         */
        public $EstimatedWeeklyImpressions;
    }

    final class DateRange
    {
        public $MaxDate;
        public $MinDate;
    }

    /**
     * Defines an object that you use to specify the start and end dates of a date range.
     * @link http://msdn.microsoft.com/en-us/library/mt219345(v=msads.100).aspx DayMonthAndYear Data Object
     * 
     * @used-by AdGroupBidLandscape
     * @used-by HistoricalSearchCountPeriodic
     * @used-by KeywordBidLandscape
     * @used-by GetHistoricalSearchCountRequest
     */
    final class DayMonthAndYear
    {
        /**
         * The day of the month.
         * @var integer
         */
        public $Day;

        /**
         * The month specified as an integer value in the range of 1 through 12, where 1 is January and 12 is December.
         * @var integer
         */
        public $Month;

        /**
         * The year specified as a four-digit integer value.
         * @var integer
         */
        public $Year;
    }

    /**
     * Defines an object that contains estimates of clicks, average cost per click (CPC), impressions, click-through rate (CTR), and total cost for the corresponding keyword or ad group given the suggested bid.
     * @link http://msdn.microsoft.com/en-us/library/mt219348(v=msads.100).aspx EstimatedBidAndTraffic Data Object
     * 
     * @uses Currency
     * @uses MatchType
     * @used-by KeywordEstimatedBid
     * @used-by GetEstimatedBidByKeywordsResponse
     */
    final class EstimatedBidAndTraffic
    {
        /**
         * The estimated minimum number of clicks per week.
         * @var double
         */
        public $MinClicksPerWeek;

        /**
         * The estimated maximum number of clicks per week.
         * @var double
         */
        public $MaxClicksPerWeek;

        /**
         * The estimated average CPC.
         * @var double
         */
        public $AverageCPC;

        /**
         * The estimated minimum number of impressions per week.
         * @var integer
         */
        public $MinImpressionsPerWeek;

        /**
         * The estimated maximum number of impressions per week.
         * @var integer
         */
        public $MaxImpressionsPerWeek;

        /**
         * The estimated CTR.
         * @var double
         */
        public $CTR;

        /**
         * The estimated minimum cost per week.
         * @var double
         */
        public $MinTotalCostPerWeek;

        /**
         * The estimated maximum cost per week.
         * @var double
         */
        public $MaxTotalCostPerWeek;

        /**
         * The monetary unit of the cost estimates and suggested bid value.
         * @var Currency
         */
        public $Currency;

        /**
         * The match type used to determine the estimates.
         * @var MatchType
         */
        public $MatchType;

        /**
         * The suggested bid value.
         * @var double
         */
        public $EstimatedMinBid;
    }

    /**
     * Defines an object that contains the estimated search results position and estimated keyword statistics such as clicks, average cost per click (CPC), impressions, click-through rate (CTR), and total cost for the specified keyword given the specified bid.
     * @link http://msdn.microsoft.com/en-us/library/mt219324(v=msads.100).aspx EstimatedPositionAndTraffic Data Object
     * 
     * @uses MatchType
     * @uses Currency
     * @used-by KeywordEstimatedPosition
     */
    final class EstimatedPositionAndTraffic
    {
        /**
         * The keyword match type used to determine the estimates.
         * @var MatchType
         */
        public $MatchType;

        /**
         * The estimated minimum number of clicks per week.
         * @var double
         */
        public $MinClicksPerWeek;

        /**
         * The estimated maximum number of clicks per week.
         * @var double
         */
        public $MaxClicksPerWeek;

        /**
         * The estimated average CPC.
         * @var double
         */
        public $AverageCPC;

        /**
         * The estimated minimum number of impressions per week.
         * @var integer
         */
        public $MinImpressionsPerWeek;

        /**
         * The estimated maximum number of impressions per week.
         * @var integer
         */
        public $MaxImpressionsPerWeek;

        /**
         * The estimated CTR.
         * @var double
         */
        public $CTR;

        /**
         * The estimated minimum cost per week.
         * @var double
         */
        public $MinTotalCostPerWeek;

        /**
         * The estimated maximum cost per week.
         * @var double
         */
        public $MaxTotalCostPerWeek;

        /**
         * The monetary unit of the cost values, such as AverageCPC.
         * @var Currency
         */
        public $Currency;

        /**
         * The position in the search results given the specified bid.
         * @var double
         */
        public $EstimatedAdPosition;
    }

    /**
     * Defines an object that contains the number of times that the keyword was used in a search query during the specified time period.
     * @link http://msdn.microsoft.com/en-us/library/mt219325(v=msads.100).aspx HistoricalSearchCountPeriodic Data Object
     * 
     * @uses DayMonthAndYear
     * @used-by SearchCountsByAttributes
     */
    final class HistoricalSearchCountPeriodic
    {
        /**
         * The number of times that the keyword was used in a search query on the specified device type during the time period.
         * @var integer
         */
        public $SearchCount;

        /**
         * The time period in which the count was captured.
         * @var DayMonthAndYear
         */
        public $DayMonthAndYear;
    }

    /**
     * Defines an object that contains a suggested keyword and a confidence score.
     * @link http://msdn.microsoft.com/en-us/library/mt219341(v=msads.100).aspx KeywordAndConfidence Data Object
     * 
     * @used-by KeywordSuggestion
     * @used-by SuggestKeywordsForUrlResponse
     */
    final class KeywordAndConfidence
    {
        /**
         * The suggested keyword.
         * @var string
         */
        public $SuggestedKeyword;

        /**
         * A score from 0.
         * @var double
         */
        public $ConfidenceScore;
    }

    /**
     * Defines an object that contains a keyword and corresponding match types.
     * @link http://msdn.microsoft.com/en-us/library/mt219342(v=msads.100).aspx KeywordAndMatchType Data Object
     * 
     * @uses MatchType
     * @used-by GetEstimatedBidByKeywordsRequest
     */
    final class KeywordAndMatchType
    {
        /**
         * The keyword text.
         * @var string
         */
        public $KeywordText;

        /**
         * The corresponding match types for the keyword.
         * @var MatchType[]
         */
        public $MatchTypes;
    }

    /**
     * Defines an object that contains a list of estimated clicks, cost, and impressions from 1 to 7 days for the keyword identifier given the suggested bid.
     * @link http://msdn.microsoft.com/en-us/library/mt219347(v=msads.100).aspx KeywordBidLandscape Data Object
     * 
     * @uses DayMonthAndYear
     * @uses BidLandscapePoint
     * @used-by GetBidLandscapeByKeywordIdsResponse
     */
    final class KeywordBidLandscape
    {
        /**
         * The keyword identifier.
         * @var integer
         */
        public $KeywordId;

        /**
         * The first date used to calculate the bid landscape.
         * @var DayMonthAndYear
         */
        public $StartDate;

        /**
         * The most recent date used to calculate the bid landscape.
         * @var DayMonthAndYear
         */
        public $EndDate;

        /**
         * The list of the total estimated clicks, cost, and impressions from StartDate to EndDate given the suggested bid.
         * @var BidLandscapePoint[]
         */
        public $BidLandscapePoints;
    }

    /**
     * Defines an object that contains a keyword category and a confidence score.
     * @link http://msdn.microsoft.com/en-us/library/mt219331(v=msads.100).aspx KeywordCategory Data Object
     * 
     * @used-by KeywordCategoryResult
     */
    final class KeywordCategory
    {
        /**
         * The keyword category that the keyword might belong to.
         * @var string
         */
        public $Category;

        /**
         * A score from 0.
         * @var double
         */
        public $ConfidenceScore;
    }

    /**
     * Defines an object that contains the keyword and a list of keyword categories that the keyword might belong to.
     * @link http://msdn.microsoft.com/en-us/library/mt219282(v=msads.100).aspx KeywordCategoryResult Data Object
     * 
     * @uses KeywordCategory
     * @used-by GetKeywordCategoriesResponse
     */
    final class KeywordCategoryResult
    {
        /**
         * The keyword being categorized.
         * @var string
         */
        public $Keyword;

        /**
         * An array of KeywordCategory objects that contains a keyword category and a score that indicates the confidence that the keyword belongs to that keyword category.
         * @var KeywordCategory[]
         */
        public $KeywordCategories;
    }

    /**
     * Defines an object that contains the device, age and gender of the user who entered the search query, if known.
     * @link http://msdn.microsoft.com/en-us/library/mt219283(v=msads.100).aspx KeywordDemographic Data Object
     * 
     * @used-by KeywordDemographicResult
     */
    final class KeywordDemographic
    {
        /**
         * The device of the user who entered the search query.
         * @var string
         */
        public $Device;

        /**
         * The percentage of time that users 18 through 24 years of age searched for the keyword.
         * @var double
         */
        public $Age18_24;

        /**
         * The percentage of time that users 25 through 34 years of age searched for the keyword.
         * @var double
         */
        public $Age25_34;

        /**
         * The percentage of time that users 35 through 49 years of age searched for the keyword.
         * @var double
         */
        public $Age35_49;

        /**
         * The percentage of time that users 50 through 64 years of age searched for the keyword.
         * @var double
         */
        public $Age50_64;

        /**
         * The percentage of time that users 65 years of age or older searched for the keyword.
         * @var double
         */
        public $Age65Plus;

        /**
         * Not used.
         * @var double
         */
        public $AgeUnknown;

        /**
         * The percentage of time that female users searched for the keyword.
         * @var double
         */
        public $Female;

        /**
         * The percentage of time that male users searched for the keyword.
         * @var double
         */
        public $Male;

        /**
         * Not Used.
         * @var double
         */
        public $GenderUnknown;
    }

    /**
     * Defines an object that contains the keyword and percentage of users by age and gender (if known) who searched for the specified keyword.
     * @link http://msdn.microsoft.com/en-us/library/mt219288(v=msads.100).aspx KeywordDemographicResult Data Object
     * 
     * @uses KeywordDemographic
     * @used-by GetKeywordDemographicsResponse
     */
    final class KeywordDemographicResult
    {
        /**
         * The keyword.
         * @var string
         */
        public $Keyword;

        /**
         * An array of KeywordDemographic data objects that contains the percentage of users by age and gender (if known) that searched for the keyword on the device.
         * @var KeywordDemographic[]
         */
        public $KeywordDemographics;
    }

    /**
     * Defines an object that contains the keyword and the estimated bid value for each match type.
     * @link http://msdn.microsoft.com/en-us/library/mt219290(v=msads.100).aspx KeywordEstimatedBid Data Object
     * 
     * @uses EstimatedBidAndTraffic
     * @used-by KeywordIdEstimatedBid
     * @used-by GetEstimatedBidByKeywordsResponse
     */
    final class KeywordEstimatedBid
    {
        /**
         * The keyword to which the estimates apply.
         * @var string
         */
        public $Keyword;

        /**
         * A list of EstimatedBidAndTraffic data objects that contains the suggested bid value for the keyword and match type.
         * @var EstimatedBidAndTraffic[]
         */
        public $EstimatedBids;
    }

    /**
     * Defines an object that contains the keyword and the estimated position in the search results for each match type.
     * @link http://msdn.microsoft.com/en-us/library/mt219294(v=msads.100).aspx KeywordEstimatedPosition Data Object
     * 
     * @uses EstimatedPositionAndTraffic
     * @used-by KeywordIdEstimatedPosition
     * @used-by GetEstimatedPositionByKeywordsResponse
     */
    final class KeywordEstimatedPosition
    {
        /**
         * The keyword to which the estimates apply.
         * @var string
         */
        public $Keyword;

        /**
         * An array of EstimatedPositionAndTraffic data objects that contains the position in the search results corresponding to the specified maximum bid.
         * @var EstimatedPositionAndTraffic[]
         */
        public $EstimatedPositions;
    }

    /**
     * Defines an object that contains the key performance index data for the specified keyword.
     * @link http://msdn.microsoft.com/en-us/library/mt219292(v=msads.100).aspx KeywordHistoricalPerformance Data Object
     * 
     * @uses KeywordKPI
     * @used-by GetHistoricalKeywordPerformanceResponse
     */
    final class KeywordHistoricalPerformance
    {
        /**
         * The keyword to which the keyword performance data applies.
         * @var string
         */
        public $Keyword;

        /**
         * An array of KeywordKPI objects that contains the performance data.
         * @var KeywordKPI[]
         */
        public $KeywordKPIs;
    }

    /**
     * Defines an object that contains the identifier of the keyword and the suggested bid value for the keyword and match type.
     * @link http://msdn.microsoft.com/en-us/library/mt219295(v=msads.100).aspx KeywordIdEstimatedBid Data Object
     * 
     * @uses KeywordEstimatedBid
     * @used-by GetEstimatedBidByKeywordIdsResponse
     */
    final class KeywordIdEstimatedBid
    {
        /**
         * The identifier of the keyword to which the suggested bid applies.
         * @var integer
         */
        public $KeywordId;

        /**
         * An object that contains the keyword string and the suggested bid value for each match type.
         * @var KeywordEstimatedBid
         */
        public $KeywordEstimatedBid;
    }

    /**
     * Defines an object that contains the identifier of a keyword and the estimated search results position for the keyword and match type.
     * @link http://msdn.microsoft.com/en-us/library/mt219296(v=msads.100).aspx KeywordIdEstimatedPosition Data Object
     * 
     * @uses KeywordEstimatedPosition
     * @used-by GetEstimatedPositionByKeywordIdsResponse
     */
    final class KeywordIdEstimatedPosition
    {
        /**
         * The identifier of the keyword to which the estimated position applies.
         * @var integer
         */
        public $KeywordId;

        /**
         * An object that contains the keyword string and estimated position in the search results given the specified maximum bid.
         * @var KeywordEstimatedPosition
         */
        public $KeywordEstimatedPosition;
    }

    /**
     * Defines a key performance index object for a keyword.
     * @link http://msdn.microsoft.com/en-us/library/mt219293(v=msads.100).aspx KeywordKPI Data Object
     * 
     * @uses MatchType
     * @uses AdPosition
     * @used-by KeywordHistoricalPerformance
     */
    final class KeywordKPI
    {
        /**
         * The device where the ad appeared.
         * @var string
         */
        public $Device;

        /**
         * The match type that you specified in the request.
         * @var MatchType
         */
        public $MatchType;

        /**
         * The position in the search results in which the ad appeared.
         * @var AdPosition
         */
        public $AdPosition;

        /**
         * The number of clicks that the keyword and match type generated during the specified time interval.
         * @var integer
         */
        public $Clicks;

        /**
         * The number of impressions that the keyword and match type generated during the specified time interval.
         * @var integer
         */
        public $Impressions;

        /**
         * The average cost per click (CPC).
         * @var double
         */
        public $AverageCPC;

        /**
         * The click-through rate (CTR) as a percentage.
         * @var double
         */
        public $CTR;

        /**
         * The cost of using the specified keyword and match type during the specified time interval.
         * @var double
         */
        public $TotalCost;

        /**
         * The average bid of the keyword.
         * @var double
         */
        public $AverageBid;
    }

    /**
     * Defines an object that contains the location, network, device, and the percentage of time that a user entered a search query.
     * @link http://msdn.microsoft.com/en-us/library/mt219301(v=msads.100).aspx KeywordLocation Data Object
     * 
     * @used-by KeywordLocationResult
     */
    final class KeywordLocation
    {
        /**
         * The device of the user who entered the search query.
         * @var string
         */
        public $Device;

        /**
         * The country, state, metropolitan area, or city where users entered the search query.
         * @var string
         */
        public $Location;

        /**
         * The percentage of time that users searched for the keyword from the location.
         * @var double
         */
        public $Percentage;
    }

    /**
     * Defines an object that contains the locations where users were located when they searched for the specified keyword.
     * @link http://msdn.microsoft.com/en-us/library/mt219299(v=msads.100).aspx KeywordLocationResult Data Object
     * 
     * @uses KeywordLocation
     * @used-by GetKeywordLocationsResponse
     */
    final class KeywordLocationResult
    {
        /**
         * The keyword.
         * @var string
         */
        public $Keyword;

        /**
         * An array of KeywordLocation objects that contains the users' geographical locations and the percentage of times that users searched for the keyword from that location.
         * @var KeywordLocation[]
         */
        public $KeywordLocations;
    }

    /**
     * Defines an object that contains a list of search counts for each device and network where the keyword was included in a search query.
     * @link http://msdn.microsoft.com/en-us/library/mt219303(v=msads.100).aspx KeywordSearchCount Data Object
     * 
     * @uses SearchCountsByAttributes
     * @used-by GetHistoricalSearchCountResponse
     */
    final class KeywordSearchCount
    {
        /**
         * The keyword to which the search count data applies.
         * @var string
         */
        public $Keyword;

        /**
         * An array of SearchCountsByAttributes objects that contain search counts for each device and network where the keyword was included in a search query.
         * @var SearchCountsByAttributes[]
         */
        public $SearchCountsByAttributes;
    }

    /**
     * Defines an object that contains a list of suggested keywords that may perform better than the specified keyword.
     * @link http://msdn.microsoft.com/en-us/library/mt219313(v=msads.100).aspx KeywordSuggestion Data Object
     * 
     * @uses KeywordAndConfidence
     * @used-by SuggestKeywordsFromExistingKeywordsResponse
     */
    final class KeywordSuggestion
    {
        /**
         * The keyword to which the suggested keywords apply.
         * @var string
         */
        public $Keyword;

        /**
         * A KeywordAndConfidence array that contains a list of suggested keywords and, for each keyword, a score that indicates the probability that using the keyword would result in an ad being included in the results of a search query.
         * @var KeywordAndConfidence[]
         */
        public $SuggestionsAndConfidence;
    }

    /**
     * Defines an error object that contains the details that explain why the service operation failed.
     * @link http://msdn.microsoft.com/en-us/library/mt219310(v=msads.100).aspx OperationError Data Object
     * 
     * @used-by ApiFaultDetail
     */
    final class OperationError
    {
        /**
         * A numeric error code that identifies the error
         * @var integer
         */
        public $Code;

        /**
         * A message that provides additional details about the error.
         * @var string
         */
        public $Details;

        /**
         * A symbolic string constant that identifies the error.
         * @var string
         */
        public $ErrorCode;

        /**
         * A message that describes the error.
         * @var string
         */
        public $Message;
    }

    final class OrderBy
    {
        public $SortOrder;
        public $SortingField;
    }

    final class Paging
    {
        public $Index;
        public $Size;
    }

    final class Predicate
    {
        public $FilteringField;
        public $Operator;
        public $Values;
    }

    /**
     * Defines an object that contains a list of keyword historical search counts for the corresponding device attribute.
     * @link http://msdn.microsoft.com/en-us/library/mt179362(v=msads.100).aspx SearchCountsByAttributes Data Object
     * 
     * @uses HistoricalSearchCountPeriodic
     * @used-by KeywordSearchCount
     */
    final class SearchCountsByAttributes
    {
        /**
         * The device of the user who entered the search query.
         * @var string
         */
        public $Device;

        /**
         * An array of HistoricalSearchCountPeriodic objects that contain a count of the number of times that the keyword was used in a search query.
         * @var HistoricalSearchCountPeriodic[]
         */
        public $HistoricalSearchCounts;
    }

    final class Selector
    {
        public $DateRange;
        public $GroupBy;
        public $Ordering;
        public $PageInfo;
        public $Predicates;
        public $SelectedFields;
    }

    final class GetAuctionInsightDataRequest
    {
        public $Selector;
    }

    final class GetAuctionInsightDataResponse
    {
        public $Result;
    }

    /**
     * Given a list of existing ad groups, this operation returns for each a list of suggested bids and estimated performance statistics.
     * @link http://msdn.microsoft.com/en-us/library/mt219284(v=msads.100).aspx GetBidLandscapeByAdGroupIds Request Object
     * 
     * @uses AdGroupBidLandscapeInput
     * @used-by BingAdsAdInsightService::GetBidLandscapeByAdGroupIds
     */
    final class GetBidLandscapeByAdGroupIdsRequest
    {
        /**
         * An array of ad group identifiers with corresponding bid landscape type input.
         * @var AdGroupBidLandscapeInput[]
         */
        public $AdGroupBidLandscapeInputs;
    }

    /**
     * Given a list of existing ad groups, this operation returns for each a list of suggested bids and estimated performance statistics.
     * @link http://msdn.microsoft.com/en-us/library/mt219284(v=msads.100).aspx GetBidLandscapeByAdGroupIds Response Object
     * 
     * @uses AdGroupBidLandscape
     * @used-by BingAdsAdInsightService::GetBidLandscapeByAdGroupIds
     */
    final class GetBidLandscapeByAdGroupIdsResponse
    {
        /**
         * An array of AdGroupBidLandscape objects.
         * @var AdGroupBidLandscape[]
         */
        public $BidLandscape;
    }

    /**
     * Given a list of existing keywords, this operation returns for each a list of suggested bids and estimated performance statistics.
     * @link http://msdn.microsoft.com/en-us/library/mt219285(v=msads.100).aspx GetBidLandscapeByKeywordIds Request Object
     * 
     * @used-by BingAdsAdInsightService::GetBidLandscapeByKeywordIds
     */
    final class GetBidLandscapeByKeywordIdsRequest
    {
        /**
         * An array of identifiers of the keywords for which you want to get the list of suggested bid values with estimated performance statistics.
         * @var integer[]
         */
        public $KeywordIds;

        /**
         * When set to false, the suggested bid values might not include the keyword's current bid.
         * @var boolean
         */
        public $IncludeCurrentBid;
    }

    /**
     * Given a list of existing keywords, this operation returns for each a list of suggested bids and estimated performance statistics.
     * @link http://msdn.microsoft.com/en-us/library/mt219285(v=msads.100).aspx GetBidLandscapeByKeywordIds Response Object
     * 
     * @uses KeywordBidLandscape
     * @used-by BingAdsAdInsightService::GetBidLandscapeByKeywordIds
     */
    final class GetBidLandscapeByKeywordIdsResponse
    {
        /**
         * An array of KeywordBidLandscape objects.
         * @var KeywordBidLandscape[]
         */
        public $BidLandscape;
    }

    /**
     * Gets the keyword bid opportunities of the specified ad group.
     * @link http://msdn.microsoft.com/en-us/library/mt219287(v=msads.100).aspx GetBidOpportunities Request Object
     * 
     * @uses BidOpportunityType
     * @used-by BingAdsAdInsightService::GetBidOpportunities
     */
    final class GetBidOpportunitiesRequest
    {
        /**
         * The identifier of the ad group for which you want to determine keyword bid opportunities.
         * @var integer
         */
        public $AdGroupId;

        /**
         * The identifier of the campaign that owns the ad group specified in the AdGroupId element.
         * @var integer
         */
        public $CampaignId;

        /**
         * Determines the type or types of bid opportunities corresponding to your ad position goals.
         * @var BidOpportunityType
         */
        public $OpportunityType;
    }

    /**
     * Gets the keyword bid opportunities of the specified ad group.
     * @link http://msdn.microsoft.com/en-us/library/mt219287(v=msads.100).aspx GetBidOpportunities Response Object
     * 
     * @uses BidOpportunity
     * @used-by BingAdsAdInsightService::GetBidOpportunities
     */
    final class GetBidOpportunitiesResponse
    {
        /**
         * An array of BidOpportunity objects that identifies the keywords whose clicks and impressions may increase if you were to apply the suggested match-type bid value.
         * @var BidOpportunity[]
         */
        public $Opportunities;
    }

    /**
     * Gets the campaign budget opportunities of the specified campaign.
     * @link http://msdn.microsoft.com/en-us/library/mt219289(v=msads.100).aspx GetBudgetOpportunities Request Object
     * 
     * @used-by BingAdsAdInsightService::GetBudgetOpportunities
     */
    final class GetBudgetOpportunitiesRequest
    {
        /**
         * The identifier of the campaign for which you want to discover possible campaign budget opportunities.
         * @var integer
         */
        public $CampaignId;
    }

    /**
     * Gets the campaign budget opportunities of the specified campaign.
     * @link http://msdn.microsoft.com/en-us/library/mt219289(v=msads.100).aspx GetBudgetOpportunities Response Object
     * 
     * @uses BudgetOpportunity
     * @used-by BingAdsAdInsightService::GetBudgetOpportunities
     */
    final class GetBudgetOpportunitiesResponse
    {
        /**
         * An array of BudgetOpportunity data objects that identify the campaigns whose clicks and impressions may increase if you were to apply the suggested budget.
         * @var BudgetOpportunity[]
         */
        public $Opportunities;
    }

    /**
     * Gets the estimated bid value of one or more keywords - specified by keyword identifier - that could have resulted in an ad appearing in the targeted position in the search results in the last 7 days.
     * @link http://msdn.microsoft.com/en-us/library/mt219291(v=msads.100).aspx GetEstimatedBidByKeywordIds Request Object
     * 
     * @uses TargetAdPosition
     * @used-by BingAdsAdInsightService::GetEstimatedBidByKeywordIds
     */
    final class GetEstimatedBidByKeywordIdsRequest
    {
        /**
         * An array of identifiers of the keywords for which you want to get the suggested bid values that could have resulted in your ad appearing in the targeted position in the search results.
         * @var integer[]
         */
        public $KeywordIds;

        /**
         * The position in which you want your ads to appear in the search results.
         * @var TargetAdPosition
         */
        public $TargetPositionForAds;
    }

    /**
     * Gets the estimated bid value of one or more keywords - specified by keyword identifier - that could have resulted in an ad appearing in the targeted position in the search results in the last 7 days.
     * @link http://msdn.microsoft.com/en-us/library/mt219291(v=msads.100).aspx GetEstimatedBidByKeywordIds Response Object
     * 
     * @uses KeywordIdEstimatedBid
     * @used-by BingAdsAdInsightService::GetEstimatedBidByKeywordIds
     */
    final class GetEstimatedBidByKeywordIdsResponse
    {
        /**
         * An array of KeywordIdEstimatedBid data objects.
         * @var KeywordIdEstimatedBid[]
         */
        public $KeywordEstimatedBids;
    }

    /**
     * Gets the estimated bid value of one or more keywords that could result in an ad appearing in the targeted position in the search results.
     * @link http://msdn.microsoft.com/en-us/library/mt219297(v=msads.100).aspx GetEstimatedBidByKeywords Request Object
     * 
     * @uses KeywordAndMatchType
     * @uses TargetAdPosition
     * @uses Currency
     * @used-by BingAdsAdInsightService::GetEstimatedBidByKeywords
     */
    final class GetEstimatedBidByKeywordsRequest
    {
        /**
         * A list of KeywordAndMatchType data objects for which you want to get suggested bid values.
         * @var KeywordAndMatchType[]
         */
        public $Keywords;

        /**
         * The position where you want your ads to appear in the search results.
         * @var TargetAdPosition
         */
        public $TargetPositionForAds;

        /**
         * The language used to help determine the country to use as the source of data for estimating the bids, if the PublisherCountries element is not specified.
         * @var string
         */
        public $Language;

        /**
         * The country codes of the countries to use as the source of data for estimating the bids.
         * @var string[]
         */
        public $PublisherCountries;

        /**
         * The monetary unit to use to calculate the cost estimates and suggested bid value.
         * @var Currency
         */
        public $Currency;

        /**
         * The identifier of the campaign that owns the ad group specified in AdGroupId.
         * @var integer
         */
        public $CampaignId;

        /**
         * The identifier of the ad group whose performance data is used to help determine how well the keyword might perform in the context of the ad group.
         * @var integer
         */
        public $AdGroupId;

        /**
         * Determines whether to return estimates for keyword level bids, ad group level bids, or both.
         * @var string
         */
        public $EntityLevelBid;
    }

    /**
     * Gets the estimated bid value of one or more keywords that could result in an ad appearing in the targeted position in the search results.
     * @link http://msdn.microsoft.com/en-us/library/mt219297(v=msads.100).aspx GetEstimatedBidByKeywords Response Object
     * 
     * @uses KeywordEstimatedBid
     * @uses EstimatedBidAndTraffic
     * @used-by BingAdsAdInsightService::GetEstimatedBidByKeywords
     */
    final class GetEstimatedBidByKeywordsResponse
    {
        /**
         * An array of KeywordEstimatedBid data objects.
         * @var KeywordEstimatedBid[]
         */
        public $KeywordEstimatedBids;

        /**
         * Contains estimates of clicks, average cost per click (CPC), impressions, click-through rate (CTR), and total cost for the specified ad group if you would use the suggested bid.
         * @var EstimatedBidAndTraffic
         */
        public $AdGroupEstimatedBid;
    }

    /**
     * Gets the estimated position in the search results if the specified bid value had been used for the keywords in the last 7 days.
     * @link http://msdn.microsoft.com/en-us/library/mt219300(v=msads.100).aspx GetEstimatedPositionByKeywordIds Request Object
     * 
     * @used-by BingAdsAdInsightService::GetEstimatedPositionByKeywordIds
     */
    final class GetEstimatedPositionByKeywordIdsRequest
    {
        /**
         * An array of identifiers of the keywords for which you want to get the estimated position in the search results, based on the specified bid value.
         * @var integer[]
         */
        public $KeywordIds;

        /**
         * The maximum bid value to use to determine the estimated position in the search results.
         * @var double
         */
        public $MaxBid;
    }

    /**
     * Gets the estimated position in the search results if the specified bid value had been used for the keywords in the last 7 days.
     * @link http://msdn.microsoft.com/en-us/library/mt219300(v=msads.100).aspx GetEstimatedPositionByKeywordIds Response Object
     * 
     * @uses KeywordIdEstimatedPosition
     * @used-by BingAdsAdInsightService::GetEstimatedPositionByKeywordIds
     */
    final class GetEstimatedPositionByKeywordIdsResponse
    {
        /**
         * A list of KeywordIdEstimatedPosition data objects.
         * @var KeywordIdEstimatedPosition[]
         */
        public $KeywordEstimatedPositions;
    }

    /**
     * Gets the estimated position in the search results if the specified bid value would be used for the specified keywords.
     * @link http://msdn.microsoft.com/en-us/library/mt219298(v=msads.100).aspx GetEstimatedPositionByKeywords Request Object
     * 
     * @uses Currency
     * @uses MatchType
     * @used-by BingAdsAdInsightService::GetEstimatedPositionByKeywords
     */
    final class GetEstimatedPositionByKeywordsRequest
    {
        /**
         * An array of keywords for which you want to get the estimated position in the search results, based on the specified bid value.
         * @var string[]
         */
        public $Keywords;

        /**
         * The maximum bid value to use to determine the estimated position in the search results.
         * @var double
         */
        public $MaxBid;

        /**
         * The language used to help determine the country to use as the source of data for estimating the bids, if the PublisherCountries element is not specified.
         * @var string
         */
        public $Language;

        /**
         * The country codes of the countries to use as the source of data for estimating the bids.
         * @var string[]
         */
        public $PublisherCountries;

        /**
         * The monetary unit to use to calculate the cost estimates and suggested bid value.
         * @var Currency
         */
        public $Currency;

        /**
         * An array of unique match types for which you want to get estimates.
         * @var MatchType[]
         */
        public $MatchTypes;

        /**
         * The identifier of the campaign that owns the ad group specified in AdGroupId.
         * @var integer
         */
        public $CampaignId;

        /**
         * The identifier of the ad group whose performance data is used to help determine how well the keyword might perform in the context of the ad group.
         * @var integer
         */
        public $AdGroupId;
    }

    /**
     * Gets the estimated position in the search results if the specified bid value would be used for the specified keywords.
     * @link http://msdn.microsoft.com/en-us/library/mt219298(v=msads.100).aspx GetEstimatedPositionByKeywords Response Object
     * 
     * @uses KeywordEstimatedPosition
     * @used-by BingAdsAdInsightService::GetEstimatedPositionByKeywords
     */
    final class GetEstimatedPositionByKeywordsResponse
    {
        /**
         * An array of KeywordEstimatedPosition data objects.
         * @var KeywordEstimatedPosition[]
         */
        public $KeywordEstimatedPositions;
    }

    /**
     * Gets the historical performance of the normalized search term.
     * @link http://msdn.microsoft.com/en-us/library/mt219302(v=msads.100).aspx GetHistoricalKeywordPerformance Request Object
     * 
     * @uses TimeInterval
     * @uses AdPosition
     * @uses MatchType
     * @used-by BingAdsAdInsightService::GetHistoricalKeywordPerformance
     */
    final class GetHistoricalKeywordPerformanceRequest
    {
        /**
         * An array of keywords for which you want to get historical performance statistics.
         * @var string[]
         */
        public $Keywords;

        /**
         * The time period that identifies the data to use to determine the key performance index of the specified keywords.
         * @var TimeInterval
         */
        public $TimeInterval;

        /**
         * The position of the search results for which you want to get performance data.
         * @var AdPosition
         */
        public $TargetAdPosition;

        /**
         * The match types for which you want to get historical data.
         * @var MatchType[]
         */
        public $MatchTypes;

        /**
         * The language in which the keywords are written.
         * @var string
         */
        public $Language;

        /**
         * The country codes of the countries/regions to use as the source of the historical data.
         * @var string[]
         */
        public $PublisherCountries;

        /**
         * A list of one or more of the following device types: Computers, NonSmartphones, Smartphones, Tablets.
         * @var string[]
         */
        public $Devices;
    }

    /**
     * Gets the historical performance of the normalized search term.
     * @link http://msdn.microsoft.com/en-us/library/mt219302(v=msads.100).aspx GetHistoricalKeywordPerformance Response Object
     * 
     * @uses KeywordHistoricalPerformance
     * @used-by BingAdsAdInsightService::GetHistoricalKeywordPerformance
     */
    final class GetHistoricalKeywordPerformanceResponse
    {
        /**
         * An array of KeywordHistoricalPerformance data objects.
         * @var KeywordHistoricalPerformance[]
         */
        public $KeywordHistoricalPerformances;
    }

    /**
     * Gets the number of times the normalized term was used in a search during the specified time period.
     * @link http://msdn.microsoft.com/en-us/library/mt219308(v=msads.100).aspx GetHistoricalSearchCount Request Object
     * 
     * @uses DayMonthAndYear
     * @used-by BingAdsAdInsightService::GetHistoricalSearchCount
     */
    final class GetHistoricalSearchCountRequest
    {
        /**
         * An array of keywords for which you want to determine the number of times that the keyword was used in a search query.
         * @var string[]
         */
        public $Keywords;

        /**
         * The language in which the keywords are written.
         * @var string
         */
        public $Language;

        /**
         * The country codes of the countries/regions to use as the source of the historical data.
         * @var string[]
         */
        public $PublisherCountries;

        /**
         * The start date of the date range that identifies the data that you want to use to determine the historical search count.
         * @var DayMonthAndYear
         */
        public $StartDate;

        /**
         * The end date of the date range that identifies the data that you want to use to determine the historical search count.
         * @var DayMonthAndYear
         */
        public $EndDate;

        /**
         * You may specify whether to return data aggregated daily, weekly, or monthly.
         * @var string
         */
        public $TimePeriodRollup;

        /**
         * A list of one or more of the following device types: Computers, NonSmartphones, Smartphones, Tablets.
         * @var string[]
         */
        public $Devices;
    }

    /**
     * Gets the number of times the normalized term was used in a search during the specified time period.
     * @link http://msdn.microsoft.com/en-us/library/mt219308(v=msads.100).aspx GetHistoricalSearchCount Response Object
     * 
     * @uses KeywordSearchCount
     * @used-by BingAdsAdInsightService::GetHistoricalSearchCount
     */
    final class GetHistoricalSearchCountResponse
    {
        /**
         * An array of KeywordSearchCount data objects.
         * @var KeywordSearchCount[]
         */
        public $KeywordSearchCounts;
    }

    /**
     * Gets the keyword categories to which the specified keywords belong.
     * @link http://msdn.microsoft.com/en-us/library/mt219320(v=msads.100).aspx GetKeywordCategories Request Object
     * 
     * @used-by BingAdsAdInsightService::GetKeywordCategories
     */
    final class GetKeywordCategoriesRequest
    {
        /**
         * An array of keywords for which you want to determine the possible keyword categories that each keyword belongs to.
         * @var string[]
         */
        public $Keywords;

        /**
         * The language in which the keywords are written.
         * @var string
         */
        public $Language;

        /**
         * The country code of the country/region to use as the source of the category data.
         * @var string
         */
        public $PublisherCountry;

        /**
         * The number of categories to include in the results.
         * @var integer
         */
        public $MaxCategories;
    }

    /**
     * Gets the keyword categories to which the specified keywords belong.
     * @link http://msdn.microsoft.com/en-us/library/mt219320(v=msads.100).aspx GetKeywordCategories Response Object
     * 
     * @uses KeywordCategoryResult
     * @used-by BingAdsAdInsightService::GetKeywordCategories
     */
    final class GetKeywordCategoriesResponse
    {
        /**
         * An array of KeywordCategoryResult data objects.
         * @var KeywordCategoryResult[]
         */
        public $Result;
    }

    /**
     * Gets the age and gender of users who have searched for the specified keywords.
     * @link http://msdn.microsoft.com/en-us/library/mt219307(v=msads.100).aspx GetKeywordDemographics Request Object
     * 
     * @used-by BingAdsAdInsightService::GetKeywordDemographics
     */
    final class GetKeywordDemographicsRequest
    {
        /**
         * An array of keywords for which you want to get demographics data.
         * @var string[]
         */
        public $Keywords;

        /**
         * The language in which the keywords are written.
         * @var string
         */
        public $Language;

        /**
         * The country code of the country/region to use as the source of the demographics data.
         * @var string
         */
        public $PublisherCountry;

        /**
         * A list of one or more of the following device types: Computers, NonSmartphones, Smartphones, Tablets.
         * @var string[]
         */
        public $Device;
    }

    /**
     * Gets the age and gender of users who have searched for the specified keywords.
     * @link http://msdn.microsoft.com/en-us/library/mt219307(v=msads.100).aspx GetKeywordDemographics Response Object
     * 
     * @uses KeywordDemographicResult
     * @used-by BingAdsAdInsightService::GetKeywordDemographics
     */
    final class GetKeywordDemographicsResponse
    {
        /**
         * An array of KeywordDemographicResult data objects.
         * @var KeywordDemographicResult[]
         */
        public $KeywordDemographicResult;
    }

    /**
     * Gets the geographical locations of users who have searched for the specified keywords.
     * @link http://msdn.microsoft.com/en-us/library/mt219328(v=msads.100).aspx GetKeywordLocations Request Object
     * 
     * @used-by BingAdsAdInsightService::GetKeywordLocations
     */
    final class GetKeywordLocationsRequest
    {
        /**
         * An array of keywords for which you want to get geographical location information.
         * @var string[]
         */
        public $Keywords;

        /**
         * The language in which the keywords are written.
         * @var string
         */
        public $Language;

        /**
         * The country code of the country/region to use as the source of the location data.
         * @var string
         */
        public $PublisherCountry;

        /**
         * A list of one or more of the following device types: Computers, NonSmartphones, Smartphones, Tablets.
         * @var string[]
         */
        public $Device;

        /**
         * The level at which to aggregate the geographical location data.
         * @var integer
         */
        public $Level;

        /**
         * The country from which the search originated.
         * @var string
         */
        public $ParentCountry;

        /**
         * The maximum number of locations to return.
         * @var integer
         */
        public $MaxLocations;
    }

    /**
     * Gets the geographical locations of users who have searched for the specified keywords.
     * @link http://msdn.microsoft.com/en-us/library/mt219328(v=msads.100).aspx GetKeywordLocations Response Object
     * 
     * @uses KeywordLocationResult
     * @used-by BingAdsAdInsightService::GetKeywordLocations
     */
    final class GetKeywordLocationsResponse
    {
        /**
         * An array of KeywordLocationResult data objects.
         * @var KeywordLocationResult[]
         */
        public $KeywordLocationResult;
    }

    /**
     * Gets a list of keyword suggestions that are relevant to the specified ad group.
     * @link http://msdn.microsoft.com/en-us/library/mt219321(v=msads.100).aspx GetKeywordOpportunities Request Object
     * 
     * @uses KeywordOpportunityType
     * @used-by BingAdsAdInsightService::GetKeywordOpportunities
     */
    final class GetKeywordOpportunitiesRequest
    {
        /**
         * The identifier of the ad group to get keyword suggestions for.
         * @var integer
         */
        public $AdGroupId;

        /**
         * The identifier of the campaign that owns the specified ad group.
         * @var integer
         */
        public $CampaignId;

        /**
         * Determines the type or types of keyword opportunities that you want.
         * @var KeywordOpportunityType
         */
        public $OpportunityType;
    }

    /**
     * Gets a list of keyword suggestions that are relevant to the specified ad group.
     * @link http://msdn.microsoft.com/en-us/library/mt219321(v=msads.100).aspx GetKeywordOpportunities Response Object
     * 
     * @uses KeywordOpportunity
     * @used-by BingAdsAdInsightService::GetKeywordOpportunities
     */
    final class GetKeywordOpportunitiesResponse
    {
        /**
         * A list of KeywordOpportunity data objects that identifies a suggested keyword and bid value.
         * @var KeywordOpportunity[]
         */
        public $Opportunities;
    }

    /**
     * Suggests the possible keywords for the content located at the specified URL.
     * @link http://msdn.microsoft.com/en-us/library/mt219319(v=msads.100).aspx SuggestKeywordsForUrl Request Object
     * 
     * @used-by BingAdsAdInsightService::SuggestKeywordsForUrl
     */
    final class SuggestKeywordsForUrlRequest
    {
        /**
         * The URL of the webpage to scan for possible keywords.
         * @var string
         */
        public $Url;

        /**
         * The language used by the website.
         * @var string
         */
        public $Language;

        /**
         * A positive integer value that specifies the maximum number of keywords to return.
         * @var integer
         */
        public $MaxKeywords;

        /**
         * A filter value that limits the keywords that the service returns to those that have a confidence score that is greater than or equal to the specified score.
         * @var double
         */
        public $MinConfidenceScore;

        /**
         * A value that determines whether the results exclude brand keywords.
         * @var boolean
         */
        public $ExcludeBrand;
    }

    /**
     * Suggests the possible keywords for the content located at the specified URL.
     * @link http://msdn.microsoft.com/en-us/library/mt219319(v=msads.100).aspx SuggestKeywordsForUrl Response Object
     * 
     * @uses KeywordAndConfidence
     * @used-by BingAdsAdInsightService::SuggestKeywordsForUrl
     */
    final class SuggestKeywordsForUrlResponse
    {
        /**
         * An array of KeywordAndConfidence objects that contains the possible keywords found in the content of the specified URL.
         * @var KeywordAndConfidence[]
         */
        public $Keywords;
    }

    /**
     * Suggests keywords that could perform better than the specified keywords.
     * @link http://msdn.microsoft.com/en-us/library/mt219311(v=msads.100).aspx SuggestKeywordsFromExistingKeywords Request Object
     * 
     * @used-by BingAdsAdInsightService::SuggestKeywordsFromExistingKeywords
     */
    final class SuggestKeywordsFromExistingKeywordsRequest
    {
        /**
         * An array of keywords for which you want to get suggested keywords that could perform better.
         * @var string[]
         */
        public $Keywords;

        /**
         * The language in which the keyword is written.
         * @var string
         */
        public $Language;

        /**
         * The country codes of the countries/regions to use as the source of data for determining the suggested keywords.
         * @var string[]
         */
        public $PublisherCountries;

        /**
         * The maximum number of keyword suggestions to return per specified keyword.
         * @var integer
         */
        public $MaxSuggestionsPerKeyword;

        /**
         * The provider to use to generate the keyword suggestions.
         * @var integer
         */
        public $SuggestionType;

        /**
         * A Boolean value that determines whether to remove duplicate keywords from the list of suggested keywords.
         * @var boolean
         */
        public $RemoveDuplicates;

        /**
         * A value that determines whether the results exclude brand keywords.
         * @var boolean
         */
        public $ExcludeBrand;

        /**
         * The identifier of the ad group for suggested keywords.
         * @var integer
         */
        public $AdGroupId;

        /**
         * The identifier of the campaign for suggested keywords.
         * @var integer
         */
        public $CampaignId;
    }

    /**
     * Suggests keywords that could perform better than the specified keywords.
     * @link http://msdn.microsoft.com/en-us/library/mt219311(v=msads.100).aspx SuggestKeywordsFromExistingKeywords Response Object
     * 
     * @uses KeywordSuggestion
     * @used-by BingAdsAdInsightService::SuggestKeywordsFromExistingKeywords
     */
    final class SuggestKeywordsFromExistingKeywordsResponse
    {
        /**
         * An array of KeywordSuggestion data objects.
         * @var KeywordSuggestion[]
         */
        public $KeywordSuggestions;
    }
}
